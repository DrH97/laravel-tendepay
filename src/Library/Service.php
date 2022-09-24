<?php

namespace DrH\TendePay\Library;

enum Service: string
{
    case MPESA_BUY_GOODS = 'MPESA_BUY_GOODS';
    case MPESA_PAY_BILL = 'MPESA_PAY_BILL';
}
