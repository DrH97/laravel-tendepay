<?php

namespace DrH\TendePay\Library;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class BaseClient
{
    public Client $httpClient;

    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function sendRequest(string $method, string $url, array $body): ResponseInterface
    {
        $options = [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => [],
        ];

        return $this->httpClient->request(
            $method,
            $url,
            $options
        );
    }
}
