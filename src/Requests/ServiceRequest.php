<?php

namespace DrH\TendePay\Requests;

use DrH\TendePay\Library\Service;

abstract class ServiceRequest
{
    abstract public function getServiceCode(): Service;

    abstract public function validate(): bool;

    abstract public function toArray(): array;

    abstract public function encrypt(): array;
}
