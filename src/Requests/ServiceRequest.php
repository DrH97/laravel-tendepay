<?php

namespace DrH\TendePay\Requests;

use DrH\TendePay\Library\Service;

abstract class ServiceRequest
{
    public function __construct()
    {
    }

    abstract public function getServiceCode(): Service;

    abstract public function validate(): bool;

    abstract public function toArray(): array;
}
