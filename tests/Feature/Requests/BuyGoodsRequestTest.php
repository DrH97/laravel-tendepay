<?php

namespace DrH\TendePay\Tests\Feature\Requests;

use DrH\TendePay\Exceptions\TendePayException;
use DrH\TendePay\Library\Service;
use DrH\TendePay\Requests\BuyGoodsRequest;
use Illuminate\Support\Facades\Config;

it('throws when source paybill not set', function () {
    new BuyGoodsRequest('10', 'acc_no', '123456');
})->throws(TendePayException::class, 'Source paybill is not set');

it('initializes buy goods request', function () {
    $request = new BuyGoodsRequest('10', 'acc_no', '123456', '654321');

    expect($request->getServiceCode())->toBe(Service::MPESA_BUY_GOODS);
});

it('initializes buy goods request using source paybill config', function () {
    Config::set('tendepay.source_paybill', '654321');
    $request = new BuyGoodsRequest('10', 'acc_no', '123456');

    expect($request->getServiceCode())->toBe(Service::MPESA_BUY_GOODS);
});
