<?php

namespace DrH\TendePay\Requests;

use DrH\TendePay\Exceptions\TendePayException;
use DrH\TendePay\Library\Service;

class BuyGoodsRequest extends B2BRequest
{
    /**
     * @throws TendePayException
     */
    public function __construct(
        string $amount,
        string $accountNumber,
        private readonly string $tillNumber,
        ?string $sourcePaybill = null,
    ) {
        parent::__construct($amount, $accountNumber, $sourcePaybill);
    }

    public function toArray(): array
    {
        return [
            ...parent::toArray(),
            'till_number' => $this->tillNumber,
        ];
    }

    public function getServiceCode(): Service
    {
        return Service::MPESA_BUY_GOODS;
    }

    /**
     * @throws TendePayException
     */
    public function validate(): bool
    {
        parent::validate();

        if (! is_numeric($this->tillNumber)) {
            throw new TendePayException('tillNumber should be a number');
        }

        return true;
    }
}
