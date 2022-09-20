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


];
