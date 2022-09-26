<?php

namespace DrH\TendePay\Tests\Feature\Requests;

use DrH\TendePay\Exceptions\TendePayException;
use DrH\TendePay\Requests\BaseRequest;
use Illuminate\Support\Facades\Config;

beforeEach(function () {
    Config::set('tendepay.source_paybill', '654321');
});

it('throws when username is not set', function () {
    new BaseRequest(getTestPaybillRequest());
})->throws(TendePayException::class, 'Username is not set');

it('throws when password is not set', function () {
    Config::set('tendepay.username', 'username');

    new BaseRequest(getTestPaybillRequest());
})->throws(TendePayException::class, 'Password is not set');

it('throws when msisdn is not set', function () {
    Config::set('tendepay.username', 'username');
    Config::set('tendepay.password', 'password');
    Config::set('tendepay.msisdn', '700000000');

    Config::set('tendepay.msisdn');
    new BaseRequest(getTestPaybillRequest());
})->throws(TendePayException::class, 'MSISDN is not set');

it('initializes base request', function () {
    Config::set('tendepay.username', 'username');
    Config::set('tendepay.password', 'password');
    Config::set('tendepay.msisdn', '700000000');

    $testPaybillRequest = getTestPaybillRequest();
    $request = new BaseRequest($testPaybillRequest);

    $expectedUniqueReference = $testPaybillRequest->getServiceCode()->name.$request->timestamp.$request->transactionReference.$request->password;

    expect(md5($expectedUniqueReference))->toBe($request->uniqueReference);
});

it('returns correct model values', function () {
    Config::set('tendepay.username', 'username');
    Config::set('tendepay.password', 'password');
    Config::set('tendepay.msisdn', '700000000');

    $testPaybillRequest = getTestPaybillRequest();
    $request = new BaseRequest($testPaybillRequest, '1', '', timestamp: '2');

    $actualValues = $request->getModelValues();

    $expected = [
        'unique_reference' => $request->uniqueReference,
        'transaction_reference' => '1',
        'timestamp' => '2',
        'msisdn' => '700000000',
        'text' => $testPaybillRequest->toArray(),
    ];

    expect($actualValues)->toBe($expected);
});

it('encrypts request', function () {
    Config::set('tendepay.username', 'username');
    Config::set('tendepay.password', 'password');
    Config::set('tendepay.msisdn', '700000000');

    [, $public] = generateKeyPair();
    Config::set('tendepay.encryption_key', $public);

    $request = getTestPaybillRequest();
    $encrypted = (new BaseRequest($request, '1', '', timestamp: '2'))->getEncryptedRequest();

    expect($encrypted)
        ->uniqueReference->not->toBeEmpty()->not->toEqual('10')
        ->transactionReference->not->toBeEmpty()->not->toEqual('1')
        ->text->toBeArray()
        ->timestamp->not->toBeEmpty()->not->toEqual('2');
});
