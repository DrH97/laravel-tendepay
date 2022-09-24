<?php

use DrH\TendePay\Exceptions\TendePayException;
use DrH\TendePay\Facades\TendePay;
use function DrH\TendePay\Tests\Feature\Requests\getTestPaybillRequest;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Config;

it('throws when configs are not set', function () {
    $request = getTestPaybillRequest();
    TendePay::payBillRequest($request);
})->throws(TendePayException::class);

it('can request paybill payment', function () {
    Config::set('tendepay.source_paybill', '654321');
    Config::set('tendepay.username', 'user');
    Config::set('tendepay.password', 'pass');

    [, $public] = generateKeyPair();
    Config::set('tendepay.encryption_key', $public);

    $this->mock->append(
        new Response(200, ['Content_type' => 'application/json'],
            json_encode($this->mockResponses['success'])));

    $payBillRequest = getTestPaybillRequest();
    $model = (new \DrH\TendePay\TendePay($this->core))->payBillRequest($payBillRequest, '2');

    $this->assertDatabaseHas($model->getTable(), ['id' => 1, 'transaction_reference' => 2]);
});
