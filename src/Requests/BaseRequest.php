<?php

namespace DrH\TendePay\Requests;

use DrH\TendePay\Exceptions\TendePayException;
use Illuminate\Support\Carbon;

class BaseRequest
{
    public string $uniqueReference;

    /**
     * @throws TendePayException
     */
    public function __construct(
        public ServiceRequest $text,
        public ?string $transactionReference = null,
        private string $msisdn = '',
        private ?string $username = null,
        public ?string $Password = null,
        public ?string $timestamp = null
    ) {
        $this->timestamp = $this->timestamp ?? Carbon::now()->timestamp;

        $this->setUsername();
        $this->setPassword();
        $this->setTransactionReference();

        $this->generateUniqueReference();
    }

    /**
     * @throws TendePayException
     */
    private function setUsername(): void
    {
        if (! $this->username) {
            $username = config('tendepay.username');
            if (! $username) {
                throw new TendePayException('Username is not set');
            }

            $this->username = $username;
        }
    }

    /**
     * @throws TendePayException
     */
    private function setPassword(): void
    {
        if (! $this->Password) {
            $password = config('tendepay.password');
            if (! $password) {
                throw new TendePayException('Password is not set');
            }

            $this->Password = $password;
        }
    }

    private function setTransactionReference(): void
    {
        $this->transactionReference = $this->transactionReference ?? rand();
    }

    private function generateUniqueReference(): void
    {
        $serviceCode = $this->text->getServiceCode()->name;
        $time = $this->timestamp;
        $transactionReference = $this->transactionReference;
        $password = $this->Password;

        $this->uniqueReference = md5($serviceCode.$time.$transactionReference.$password);
    }

    public function getModelValues(): array
    {
        return [
            'unique_reference' => $this->uniqueReference,
            'transaction_reference' => $this->transactionReference,
            'text' => $this->text->toArray(),
            'timestamp' => $this->timestamp,
        ];
    }
}
