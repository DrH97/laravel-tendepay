<?php

namespace DrH\TendePay\Requests;

use DrH\TendePay\Library\Service;

abstract class ServiceRequest
{
    public function __construct()
    {
    }

    abstract public function getServiceCode(): Service;
}
