<?php

namespace DrH\TendePay\Models;

use Illuminate\Database\Eloquent\Model;

class TendePayRequest extends Model
{
    protected $guarded = [];

    protected $casts = [
        'text' => 'array',
    ];
}
