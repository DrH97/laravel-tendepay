<?php

namespace DrH\TendePay\Requests;

use DrH\TendePay\Exceptions\TendePayException;
use DrH\TendePay\Library\Core;
use Illuminate\Support\Facades\App;

abstract class B2BRequest extends ServiceRequest
{
    /**
     * @throws TendePayException
     */
    public function __construct(
        private readonly string $amount,
        private readonly string $accountNumber,
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
            'source_paybill' => $this->sourcePaybill,
        ];
    }

//    public function getServiceCode(): Service
//    {
//        return Service::MPESA_PAY_BILL;
//    }

    /**
     * @throws TendePayException
     */
    public function validate(): bool
    {
        if (! is_numeric($this->amount)) {
            throw new TendePayException('amount should be a number');
        }

        if (! is_numeric($this->sourcePaybill)) {
            throw new TendePayException('sourcePaybill should be a number');
        }

        return true;
    }

    public function encrypt(): array
    {
        $core = App::make(Core::class);

        return array_map(fn ($value) => $core->encrypt($value), $this->toArray());
    }
}
