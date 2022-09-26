<?php

use DrH\TendePay\Models\TendePayCallback;
use DrH\TendePay\Models\TendePayRequest;
use Illuminate\Support\Carbon;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\postJson;

// TODO: test callback
it('fails to handle empty callback', function () {
    postJson('/tendepay/callback')->assertSuccessful()
        ->assertJson(['status' => true]);

    assertDatabaseCount((new TendePayCallback())->getTable(), 0);
});

it('fails to handle malformed callback', function () {
    postJson('/tendepay/callback', [
        // Missing initiator reference
        'responseCode' => 'responseCode',
        'status' => 'status',
        'statusDescription' => 'statusDescription',
        'amount' => 'amount',
        'account_reference' => 'account_reference',
        'confirmationcode' => 'confirmationcode',
        'msisdn' => 'msisdn',
        'receiverpartyname' => 'receiverpartyname',
        'date' => 'date',
    ])->assertSuccessful()
        ->assertJson(['status' => true]);

    assertDatabaseCount((new TendePayCallback())->getTable(), 0);
});

it('fails to handle duplicate callback', function () {
    TendePayRequest::create([
        'service' => '',
        'unique_reference' => '',
        'transaction_reference' => 'reference',
        'text' => [],
        'timestamp' => Carbon::now()->timestamp,

        'response_code' => 1,
        'response_message' => 'success',
        'status' => 'success',
    ]);

    postJson('/tendepay/callback', [
        'initiatorReference' => 'reference',
        'responseCode' => 'responseCode',
        'status' => 'status',
        'statusDescription' => 'statusDescription',
        'amount' => 'amount',
        'account_reference' => 'account_reference',
        'confirmationcode' => 'confirmationcode',
        'msisdn' => 'msisdn',
        'receiverpartyname' => 'receiverpartyname',
        'date' => 'date',
    ])->assertSuccessful()
        ->assertJson(['status' => true]);

    assertDatabaseCount((new TendePayCallback())->getTable(), 1);

    postJson('/tendepay/callback', [
        'initiatorReference' => 'initiatorReference',
        'responseCode' => 'responseCode',
        'status' => 'status',
        'statusDescription' => 'statusDescription',
        'amount' => 'amount',
        'account_reference' => 'account_reference',
        'confirmationcode' => 'confirmationcode',
        'msisdn' => 'msisdn',
        'receiverpartyname' => 'receiverpartyname',
        'date' => 'date',
    ])->assertSuccessful()
        ->assertJson(['status' => true]);

    assertDatabaseCount((new TendePayCallback())->getTable(), 1);
});
