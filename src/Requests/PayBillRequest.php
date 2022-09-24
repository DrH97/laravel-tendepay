<?php

namespace DrH\TendePay\Requests;

use DrH\TendePay\Exceptions\TendePayException;
use DrH\TendePay\Library\Service;

class PayBillRequest extends B2BRequest
{
    /**
     * @throws TendePayException
     */
    public function __construct(
        string $amount,
        string $accountNumber,
        private readonly string $payBillNumber,
        ?string $sourcePaybill = null,
    ) {
        parent::__construct($amount, $accountNumber, $sourcePaybill);
    }

    public function toArray(): array
    {
        return [
            ...parent::toArray(),
            'pay_bill_number' => $this->payBillNumber,
        ];
    }

    public function getServiceCode(): Service
    {
        return Service::MPESA_PAY_BILL;
    }

    /**
     * @throws TendePayException
     */
    public function validate(): bool
    {
        parent::validate();

        if (! is_numeric($this->payBillNumber)) {
            throw new TendePayException('payBillNumber should be a number');
        }

        return true;
    }
}
