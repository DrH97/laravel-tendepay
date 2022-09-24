<?php

use DrH\TendePay\Exceptions\TendePayException;

function generateKeyPair(): array
{
    $private_key = openssl_pkey_new();
    $public_key_pem = openssl_pkey_get_details($private_key)['key'];
    $public_key = openssl_pkey_get_public($public_key_pem);

    return [$private_key, $public_key, $public_key_pem];
}

/**
 * @throws TendePayException
 */
//function encrypt(string $plainText): string
//{
//    $pub_key = config('tendepay.encryption_key');
//    if (!$pub_key) {
//        throw new TendePayException('Encryption key is not set');
//    }
//
//    $PK = openssl_get_publickey($pub_key);
//    if (!$PK) {
//        throw new TendePayException('Encryption key seems malformed');
//    }
//
//    openssl_public_encrypt($plainText, $encrypted, $PK);
//
//    return bin2hex($encrypted);
//}
