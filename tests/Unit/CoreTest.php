<?php

namespace DrH\TendePay\Tests\Feature;

use DrH\TendePay\Exceptions\TendePayException;
use DrH\TendePay\Library\Service;
use Illuminate\Support\Facades\Config;

it('builds correct endpoints', function () {
    Config::set('tendepay.url', 'http://localhost');

    $expectedEndpoint = 'http://localhost/1/MPESA_PAY_BILL';

    $actualEndpoint = $this->core->buildEndpoint(1, Service::MPESA_PAY_BILL);

    expect($actualEndpoint)->toBe($expectedEndpoint);
});

it('throws on missing encryption key', function () {
    $this->core->encrypt(1);
})->throws(TendePayException::class, 'Encryption key is not set');

it('throws on malformed encryption key', function () {
    Config::set('tendepay.encryption_key', 'key');

    $this->core->encrypt(1);
})->throws(TendePayException::class, 'Encryption key seems malformed');

it('performs correct encryption', function () {
    [$private, $public] = generateKeyPair();
    Config::set('tendepay.encryption_key', $public);

    $encrypted = $this->core->encrypt(1);

    expect(ctype_xdigit($encrypted))->toBeTrue();

    $binaryValue = hex2bin($encrypted);
    openssl_private_decrypt($binaryValue, $decrypted, $private);

    expect($decrypted)->toBe('1');
});
