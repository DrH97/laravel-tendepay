<?php

namespace DrH\TendePay\Requests;

use DrH\TendePay\Exceptions\TendePayException;
use DrH\TendePay\Library\Service;

class PayBillRequest extends ServiceRequest
{
    /**
     * @throws TendePayException
     */
    public function __construct(
        private string $amount,
        private string $accountNumber,
        private string $payBillNumber,
        private ?string $sourcePaybill = null,
    ) {
        $this->setSourcePaybill();
    }

    /**
     * @throws TendePayException
     */
    private function setSourcePaybill(): void
    {
        if (! $this->sourcePaybill) {
            $sourcePaybill = config('tendepay.source_paybill');
            if (! $sourcePaybill) {
                throw new TendePayException('Source paybill is not set');
            }

            $this->sourcePaybill = $sourcePaybill;
        }
    }

    // TODO: To base class
    public function toArray(): array
    {
        return [
            'amount' => $this->amount,
            'account_number' => $this->accountNumber,
            'pay_bill_number' => $this->payBillNumber,
            'source_paybill' => $this->sourcePaybill,
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
        throw new TendePayException('Something is not right');
        // TODO: Implement validate() method.
        // TODO: Validate amount is int, paybill is int, source_paybill is int
        return true;
    }
}
