<?php

use DrH\TendePay\Models\TendePayCallback;
use DrH\TendePay\Models\TendePayRequest;
use Illuminate\Support\Carbon;

it('can run migrations', function () {
    TendePayRequest::create([
        'unique_reference' => '',
        'transaction_reference' => 1,
        'text' => [],
        'timestamp' => Carbon::now()->timestamp,

        'response_code' => 1,
        'response_message' => 'success',
        'status' => 'success',
    ]);

    $request = TendePayRequest::first();

    expect($request->transaction_reference)->toBe('1');

    TendePayCallback::create([
        'initiator_reference' => 1,

        'response_code' => 1,
        'status' => 1,
        'status_description' => 'success',

        'amount' => 10,
        'account_reference' => 'test',
        'confirmation_code' => 'Q...',
        'msisdn' => 712345678,
        'receiver_party_name' => 'Name',
        'date' => Carbon::now()->toDateTimeString(),
    ]);

    $callback = TendePayCallback::first();

    expect($callback->initiator_reference)->toBe('1');
});
