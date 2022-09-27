<?php

namespace DrH\TendePay\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * TendePayCallback
 *
 * @property string $initiator_reference
 * @property string $response_code
 * @property string $status
 * @property string $status_description
 * @property float $amount
 * @property string $account_reference
 * @property string $confirmation_code
 * @property string $msisdn
 * @property ?string $receiver_party_name
 * @property string $date
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @method static Builder|TendePayCallback whereInitiatorReference()
 * …
 */
class TendePayCallback extends Model
{
    protected $guarded = [];

    public function request(): HasOne
    {
        return $this->hasOne(TendePayRequest::class, 'transaction_reference', 'initiator_reference');
    }
}
