<?php

use Illuminate\Support\Facades\Log;
use Psr\Log\LoggerInterface;

function generateKeyPair(): array
{
    $private_key = openssl_pkey_new();
    $public_key_pem = openssl_pkey_get_details($private_key)['key'];
    $public_key = openssl_pkey_get_public($public_key_pem);

    return [$private_key, $public_key, $public_key_pem];
}

//TODO: Add tests for all these helpers
//    e.g. if logging channels doesn't exist, we shouldn't throw error
if (! function_exists('shouldLog')) {
    function shouldLog(): bool
    {
        return config('tendepay.logging.enabled') == true;
    }
}

if (! function_exists('getLogger')) {
    function getLogger(): LoggerInterface
    {
        if (shouldLog()) {
            $channels = [];
            foreach (config('tendepay.logging.channels') as $rawChannel) {
                if (is_string($rawChannel)) {
                    $channels[] = $rawChannel;
                } elseif (is_array($rawChannel)) {
                    $channels[] = Log::build($rawChannel);
                }
            }

            return Log::stack($channels);
        }

        return Log::build([
            'driver' => 'single',
            'path' => '/dev/null',
        ]);
    }
}

if (! function_exists('tendePayLog')) {
    function tendePayLog(string $level, string $message, array $context = []): void
    {
        $message = '[LIB - TENDE]: '.$message;
        getLogger()->log($level, $message, $context);
    }
}

if (! function_exists('tendePayLogError')) {
    function tendePayLogError(string $message, array $context = []): void
    {
        $message = '[LIB - TENDE]: '.$message;
        getLogger()->error($message, $context);
    }
}

if (! function_exists('tendePayLogInfo')) {
    function tendePayLogInfo(string $message, array $context = []): void
    {
        $message = '[LIB - TENDE]: '.$message;
        getLogger()->info($message, $context);
    }
}
