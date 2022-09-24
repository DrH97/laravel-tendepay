<?php

function generateKeyPair(): array
{
    $private_key = openssl_pkey_new();
    $public_key_pem = openssl_pkey_get_details($private_key)['key'];
    $public_key = openssl_pkey_get_public($public_key_pem);

    return [$private_key, $public_key, $public_key_pem];
}

//function encrypt(string $plainText): string
//{
//    $fp = fopen('hf_key.pem', 'r');
//    $pub_key = fread($fp, 8192);
//    fclose($fp);
//
//    $PK = openssl_get_publickey($pub_key);
//    if (! $PK) {
//        echo 'Cannot get public key';
//    }
//
//    openssl_public_encrypt($plainText, $encrypted, $PK);
//
//    return bin2hex($encrypted);
//}
