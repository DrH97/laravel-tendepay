<?php

namespace DrH\TendePay\Requests;

use DrH\TendePay\Exceptions\TendePayException;
use DrH\TendePay\Library\Service;

class BuyGoodsRequest extends ServiceRequest
{
    /**
     * @throws TendePayException
     */
    public function __construct(
        private string $amount,
        private string $account_number,
        private string $till_number,
        private ?string $source_paybill = null,
    ) {
        $this->setSourcePaybill();
    }

    /**
     * @throws TendePayException
     */
    private function setSourcePaybill(): void
    {
        if (! $this->source_paybill) {
            $sourcePaybill = config('tendepay.source_paybill');
            if (! $sourcePaybill) {
                throw new TendePayException('Source paybill is not set');
            }

            $this->source_paybill = $sourcePaybill;
        }
    }

//    public function __serialize(): array
//    {
//        // TODO: Implement __serialize() method.
//        return [
//
//        ];
//    }
    public function getServiceCode(): Service
    {
        return Service::MPESA_BUY_GOODS;
    }
}
