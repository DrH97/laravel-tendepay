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
        public string $transactionReference,
        public ServiceRequest $text,
        private string $msisdn,
        private ?string $username = null,
        public ?string $Password = null,
        public ?string $timestamp = null
    ) {
        $this->setUsername();
        $this->setPassword();

        $this->timestamp = $this->timestamp ?? Carbon::now()->timestamp;

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

    private function generateUniqueReference(): void
    {
        $serviceCode = $this->text->getServiceCode()->name;
        $time = $this->timestamp;
        $transactionReference = $this->transactionReference;
        $password = $this->Password;

        $this->uniqueReference = md5($serviceCode.$time.$transactionReference.$password);
    }
}
