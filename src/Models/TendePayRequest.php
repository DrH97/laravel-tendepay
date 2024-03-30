<?php

namespace DrH\TendePay\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * TendePayRequest
 *
 * @property string $service
 * @property string $unique_reference
 * @property string $transaction_reference
 * @property array $text
 * @property ?string $msisdn
 * @property string $timestamp
 * @property string $response_code
 * @property string $response_message
 * @property ?string $successful
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @method static Builder|TendePayRequest whereTransactionReference(string $reference)
 *                                                                                     …
 */
class TendePayRequest extends Model
{
    protected $guarded = [];

    protected $casts = [
        'text' => 'array',
    ];

    public function callback(): HasOne
    {
        return $this->hasOne(TendePayCallback::class, 'initiator_reference', 'transaction_reference');
    }
}
