<?php

namespace DrH\TendePay\Facades;

use DrH\TendePay\Models\TendePayRequest as TR;
use DrH\TendePay\Requests\BuyGoodsRequest;
use DrH\TendePay\Requests\PayBillRequest;
use Illuminate\Support\Facades\Facade;

/**
 * @method static TR payBillRequest(PayBillRequest $request, string $reference = null, int $relationId = null)
 * @method static TR buyBoodsRequest(BuyGoodsRequest $request, string $reference = null, int $relationId = null)
 *
 * @see \DrH\TendePay\TendePay
 */
class TendePay extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \DrH\TendePay\TendePay::class;
    }
}
