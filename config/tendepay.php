<?php

return [
    /*
    |------------------------------------------------------
    | Set sandbox mode
    | ------------------------------------------------------
    | Specify whether this is a test app or production app
    |
    | Sandbox base url: 'http://144.76.108.226:8180/GatewayAPIChannel/RequestProcessor/request'
    | Production base url: https://api.tendepay.com:8443/GatewayAPIChannel/RequestProcessor/request
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
    'url' => env('TENDEPAY_URL', 'http://144.76.108.226:8180/GatewayAPIChannel/RequestProcessor/request'),

    /*
    |--------------------------------------------------------------------------
    | Encryption key
    |--------------------------------------------------------------------------
    |
    | Base 64 encoded string of the contents of the PEM file
    |
    */
    'encryption_key' => env('TENDEPAY_ENCRYPTION_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Username
    |--------------------------------------------------------------------------
    |
    | Username provided by TendePay
    |
    */
    'username' => env('TENDEPAY_USERNAME'),

    /*
    |--------------------------------------------------------------------------
    | Password
    |--------------------------------------------------------------------------
    |
    | Password provided by TendePay
    |
    */
    'password' => env('TENDEPAY_PASSWORD'),

    /*
    |--------------------------------------------------------------------------
    | Source Paybill for B2B requests
    |--------------------------------------------------------------------------
    |
    | Paybill to use for funds
    |
    */
    'source_paybill' => env('TENDEPAY_SOURCE_PAYBILL'),

    /*
    |--------------------------------------------------------------------------
    | MSISDN for requests
    |--------------------------------------------------------------------------
    |
    | MSISDN(Phone number) to use for requests
    |
    */
    'msisdn' => env('TENDEPAY_MSISDN'),

    /*
    |--------------------------------------------------------------------------
    | Logging
    |--------------------------------------------------------------------------
    |
    | Whether to log in the library
    |
    */
    'logging' => [
        'enabled' => env('TENDEPAY_ENABLE_LOGGING', false),
        'channels' => [
            'single', 'stderr',
        ],
    ],

];
