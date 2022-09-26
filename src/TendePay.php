<?php

namespace DrH\TendePay;

use DrH\TendePay\Exceptions\TendePayException;
use DrH\TendePay\Library\Core;
use DrH\TendePay\Models\TendePayRequest;
use DrH\TendePay\Requests\BaseRequest;
use DrH\TendePay\Requests\BuyGoodsRequest;
use DrH\TendePay\Requests\PayBillRequest;

class TendePay
{
    public function __construct(private readonly Core $core)
    {
    }

    /**
     * @throws TendePayException
     */
    public function b2bRequest(PayBillRequest|BuyGoodsRequest $request, string $reference = null, string $msisdn = null, int $relationId = null): TendePayRequest
    {
        $request->validate();

        // TODO: Review checking of reference against db: otherwise duplicates may fail.
        if ($reference && TendePayRequest::whereTransactionReference($reference)->exists()) {
            throw new TendePayException('Request with this reference exists');
        }

        $baseRequest = new BaseRequest($request, $reference, $msisdn);

        // TODO: Review conversion of api response to object/class
        $response = $this->core->request($baseRequest);

        return $this->saveRequest($baseRequest, $response, $relationId);
    }

    private function saveRequest(BaseRequest $request, array $response, ?int $relationId): TendePayRequest
    {
        $model = TendePayRequest::create([
            'service' => $request->text->getServiceCode(),
            ...$request->getModelValues(),

            'response_code' => $response['responseCode'],
            'response_message' => $response['responseMessage'],
            'status' => $response['status'],
            'successful' => $response['successful'] ?? null,

            'relation_id' => $relationId,
        ]);

        //TODO: TendePayEvents::fire($model);

        return $model;
    }

    //TODO: add ipn flow
}
