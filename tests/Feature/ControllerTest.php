<?php

use DrH\TendePay\Events\TendePayRequestFailedEvent;
use DrH\TendePay\Events\TendePayRequestSuccessEvent;
use DrH\TendePay\Models\TendePayCallback;
use DrH\TendePay\Models\TendePayRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Event;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;

it('fails to handle empty callback', function () {
    postJson('/tendepay/callback')->assertSuccessful()
        ->assertJson(['status' => true]);

    assertDatabaseCount((new TendePayCallback())->getTable(), 0);
});

it('fails to handle malformed callback', function () {
    postJson('/tendepay/callback', [
        // Missing initiator reference
        'responseCode'      => 'responseCode',
        'status'            => 'status',
        'statusDescription' => 'statusDescription',
        'amount'            => 'amount',
        'account_reference' => 'account_reference',
        'confirmationcode'  => 'confirmationcode',
        'msisdn'            => 'msisdn',
        'receiverpartyname' => 'receiverpartyname',
        'date'              => 'date',
    ])->assertSuccessful()
        ->assertJson(['status' => true]);

    assertDatabaseCount((new TendePayCallback())->getTable(), 0);
});

it('handles duplicate callback', function () {
    TendePayRequest::create([
        'service'               => '',
        'unique_reference'      => '',
        'transaction_reference' => 'reference',
        'text'                  => [],
        'timestamp'             => Carbon::now()->timestamp,

        'response_code'    => 1,
        'response_message' => 'success',
        'status'           => 'success',
    ]);

    assertDatabaseCount((new TendePayRequest())->getTable(), 1);
    assertDatabaseHas((new TendePayRequest())->getTable(), [
        'transaction_reference' => 'reference',
        'response_code'         => '1',
    ]);

    postJson('/tendepay/callback', [
        'initiatorReference' => 'reference',
        'responseCode'       => 'responseCode',
        'status'             => 1,
        'statusDescription'  => 'statusDescription',
        'amount'             => 'amount',
        'account_reference'  => 'account_reference',
        'confirmationcode'   => 'confirmationcode',
        'msisdn'             => 'msisdn',
        'receiverpartyname'  => 'receiverpartyname',
        'date'               => 'date',
    ])->assertSuccessful()
        ->assertJson(['status' => true]);

    assertDatabaseCount((new TendePayCallback())->getTable(), 1);

    postJson('/tendepay/callback', [
        'initiatorReference' => 'reference',
        'responseCode'       => 'responseCode',
        'status'             => '4',
        'statusDescription'  => 'statusDescription',
        'amount'             => 'amount',
        'account_reference'  => 'account_reference',
        'confirmationcode'   => 'confirmationcode',
        'msisdn'             => 'msisdn',
        'receiverpartyname'  => 'receiverpartyname',
        'date'               => 'date',
    ])->assertSuccessful()
        ->assertJson(['status' => true]);

    assertDatabaseCount((new TendePayCallback())->getTable(), 1);
    assertDatabaseHas((new TendePayCallback())->getTable(), [
        'initiator_reference' => 'reference',
        'status'              => 1,
    ]);

    Event::assertDispatched(TendePayRequestSuccessEvent::class, 1);
});

it('handles successful callback', function () {
    TendePayRequest::create([
        'service'               => '',
        'unique_reference'      => '',
        'transaction_reference' => 'reference',
        'text'                  => [],
        'timestamp'             => Carbon::now()->timestamp,

        'response_code'    => 1,
        'response_message' => 'success',
        'status'           => 'success',
    ]);

    postJson('/tendepay/callback', [
        'initiatorReference' => 'reference',
        'responseCode'       => 'responseCode',
        'status'             => '1',
        'statusDescription'  => 'statusDescription',
        'amount'             => 'amount',
        'account_reference'  => 'account_reference',
        'confirmationcode'   => 'confirmationcode',
        'msisdn'             => 'msisdn',
        'receiverpartyname'  => 'receiverpartyname',
        'date'               => 'date',
    ])->assertSuccessful()
        ->assertJson(['status' => true]);

    assertDatabaseCount((new TendePayCallback())->getTable(), 1);

    Event::assertDispatched(TendePayRequestSuccessEvent::class, 1);
});

it('handles failed callback', function () {
    TendePayRequest::create([
        'service'               => '',
        'unique_reference'      => '',
        'transaction_reference' => 'reference',
        'text'                  => [],
        'timestamp'             => Carbon::now()->timestamp,

        'response_code'    => 1,
        'response_message' => 'success',
        'status'           => 'success',
    ]);

    assertDatabaseCount((new TendePayRequest())->getTable(), 1);
    assertDatabaseHas((new TendePayRequest())->getTable(), [
        'transaction_reference' => 'reference',
        'response_code'         => '1',
    ]);

    postJson('/tendepay/callback', [
        'initiatorReference' => 'reference',
        'responseCode'       => 'responseCode',
        'status'             => '4',
        'statusDescription'  => 'statusDescription',
        'amount'             => 'amount',
        'account_reference'  => 'account_reference',
        'confirmationcode'   => 'confirmationcode',
        'msisdn'             => 'msisdn',
        'receiverpartyname'  => 'receiverpartyname',
        'date'               => 'date',
    ])->assertSuccessful()
        ->assertJson(['status' => true]);

    assertDatabaseCount((new TendePayCallback())->getTable(), 1);
    assertDatabaseHas((new TendePayCallback())->getTable(), [
        'initiator_reference' => 'reference',
        'status'              => '4',
    ]);

    Event::assertDispatched(TendePayRequestFailedEvent::class, 1);
});
