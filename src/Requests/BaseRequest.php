<?php

namespace DrH\TendePay\Requests;

use DrH\TendePay\Exceptions\TendePayException;
use DrH\TendePay\Library\Core;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;

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
            'timestamp' => $this->timestamp,
            'msisdn' => $this->msisdn,
            'text' => $this->text->toArray(),
        ];
    }

    public function getEncryptedRequest(): array
    {
        $core = App::make(Core::class);

        $arrayValues = $this->getModelValues();
        array_pop($arrayValues);

        return [
            ...array_map(fn ($value) => $core->encrypt($value), $arrayValues),
            'text' => $this->text->encrypt(),
        ];
    }
}
