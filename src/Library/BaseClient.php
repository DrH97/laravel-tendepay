<?php

namespace DrH\TendePay\Library;

use GuzzleHttp\Client;

class BaseClient
{
    public Client $httpClient;

    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function sendRequest(string $method, string $url, array $body): array
    {
        $options = [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json'    => $body,
        ];

        $response = $this->httpClient->request(
            $method,
            $url,
            $options
        );
        tendePayLogInfo('response: ', parseGuzzleResponse($response));

        return json_decode($response->getBody(), true);
    }
}
