<?php

return [
    /*
    |------------------------------------------------------
    | Set sandbox mode
    | ------------------------------------------------------
    | Specify whether this is a test app or production app
    |
    | Sandbox base url: TODO()
    | Production base url: TODO()
    */
    'sandbox' => env('TENDEPAY_SANDBOX', false),

    /*
    |--------------------------------------------------------------------------
    | Cache credentials/keys
    |--------------------------------------------------------------------------
    |
    | If you decide to cache credentials, they will be kept in your app cache
    | configuration for some time. Reducing the need for many requests for
    | generating credentials/encryption keys
    |
    */
    'cache_credentials' => true,

    /*
    |--------------------------------------------------------------------------
    | URL
    |--------------------------------------------------------------------------
    |
    | Url of the api
    |
    */
    'url' => env('TENDEPAY_URL', 'https://http://144.76.108.226:8180/GatewayAPIChannel/RequestProcessor'),

    /*
    |--------------------------------------------------------------------------
    | Encryption key location
    |--------------------------------------------------------------------------
    |
    | Location of the public key provided by TendePay
    |
    */
    'encryption_key' => env('TENDEPAY_ENCRYPTION_KEY'),

];
