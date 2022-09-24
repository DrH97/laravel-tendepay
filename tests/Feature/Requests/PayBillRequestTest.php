<?php

namespace DrH\TendePay\Tests\Feature\Requests;

use DrH\TendePay\Exceptions\TendePayException;
use DrH\TendePay\Library\Service;
use DrH\TendePay\Requests\PayBillRequest;
use Illuminate\Support\Facades\Config;

it('throws when source paybill not set', function () {
    new PayBillRequest('10', 'acc_no', '123456');
})->throws(TendePayException::class, 'Source paybill is not set');

it('initializes pay bill request', function () {
    $request = new PayBillRequest('10', 'acc_no', '123456', '654321');

    expect($request->getServiceCode())->toBe(Service::MPESA_PAY_BILL);
});

it('initializes pay bill request using source paybill config', function () {
    Config::set('tendepay.source_paybill', '654321');
    $request = new PayBillRequest('10', 'acc_no', '123456');

    expect($request->getServiceCode())->toBe(Service::MPESA_PAY_BILL);
});

function getTestPaybillRequest()
{
    return new PayBillRequest('10', 'acc_no', '123456');
}
