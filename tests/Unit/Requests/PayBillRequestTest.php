<?php

namespace DrH\TendePay\Tests\Feature\Requests;

use DrH\TendePay\Exceptions\TendePayException;
use DrH\TendePay\Library\Service;
use DrH\TendePay\Requests\PayBillRequest;
use Illuminate\Support\Facades\Config;

function getTestPaybillRequest(): PayBillRequest
{
    return new PayBillRequest('10', 'acc_no', '123456');
}

it('throws when source paybill not set', function () {
    getTestPaybillRequest();
})->throws(TendePayException::class, 'Source paybill is not set');

it('initializes pay bill request', function () {
    $request = new PayBillRequest('10', 'acc_no', '123456', '654321');

    expect($request->getServiceCode())->toBe(Service::MPESA_PAY_BILL);
});

it('initializes pay bill request using source paybill config', function () {
    Config::set('tendepay.source_paybill', '654321');
    $request = getTestPaybillRequest();

    expect($request->getServiceCode())->toBe(Service::MPESA_PAY_BILL);
});

it('converts to array', function () {
    Config::set('tendepay.source_paybill', '654321');
    $request = getTestPaybillRequest();

    $actualValues = $request->toArray();

    $expected = [
        'amount' => '10',
        'account_number' => 'acc_no',
        'source_paybill' => '654321',
        'pay_bill_number' => '123456',
    ];

    expect($actualValues)->toBe($expected);
});

it('validates values', function () {
    Config::set('tendepay.source_paybill', '654321a');

    $request = new PayBillRequest('10a', 'acc_no', '123456a');
    expect(fn () => $request->validate())
        ->toThrow(TendePayException::class, 'amount should be a number');

    $request = new PayBillRequest('10', 'acc_no', '123456a');
    expect(fn () => $request->validate())
        ->toThrow(TendePayException::class, 'sourcePaybill should be a number');

    Config::set('tendepay.source_paybill', '654321');
    $request = new PayBillRequest('10', 'acc_no', '123456a');
    expect(fn () => $request->validate())
        ->toThrow(TendePayException::class, 'payBillNumber should be a number');

    $request = new PayBillRequest('10', 'acc_no', '123456');
    expect($request->validate())->toBeTrue();
});

it('encrypts request', function () {
    Config::set('tendepay.source_paybill', '654321');

    [, $public] = generateKeyPair();
    Config::set('tendepay.encryption_key', $public);

    $encrypted = getTestPaybillRequest()->encrypt();

    expect($encrypted)
        ->amount->not->toBeEmpty()->not->toEqual('10')
        ->account_number->not->toBeEmpty()->not->toEqual('acc_no')
        ->pay_bill_number->not->toBeEmpty()->not->toEqual('123456')
        ->source_paybill->not->toBeEmpty()->not->toEqual('654321');
});
