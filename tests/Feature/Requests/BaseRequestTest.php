<?php

namespace DrH\TendePay\Tests\Feature\Requests;

use DrH\TendePay\Exceptions\TendePayException;
use DrH\TendePay\Requests\BaseRequest;
use Illuminate\Support\Facades\Config;

beforeEach(function () {
    Config::set('tendepay.source_paybill', '654321');
});

it('throws when username is not set', function () {
    new BaseRequest(1, getTestPaybillRequest(), '');
})->throws(TendePayException::class, 'Username is not set');

it('throws when password is not set', function () {
    Config::set('tendepay.username', 'username');

    new BaseRequest(1, getTestPaybillRequest(), '');
})->throws(TendePayException::class, 'Password is not set');

it('initializes base request', function () {
    Config::set('tendepay.username', 'username');
    Config::set('tendepay.password', 'password');

    $testPaybillRequest = getTestPaybillRequest();
    $request = new BaseRequest(1, $testPaybillRequest, '');

    $expectedUniqueReference = $testPaybillRequest->getServiceCode()->name.$request->timestamp.$request->transactionReference.$request->Password;

    expect(md5($expectedUniqueReference))->toBe($request->uniqueReference);
});
