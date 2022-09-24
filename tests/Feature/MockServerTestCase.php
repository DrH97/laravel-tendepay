<?php

namespace DrH\TendePay\Tests\Feature;

use DrH\TendePay\Library\BaseClient;
use DrH\TendePay\Library\Core;
use DrH\TendePay\Tests\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class MockServerTestCase extends TestCase
{
    use RefreshDatabase;

    protected BaseClient $baseClient;

    protected MockHandler $mock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mock = new MockHandler();

        $handlerStack = HandlerStack::create($this->mock);
        $this->baseClient = new BaseClient(new Client(['handler' => $handlerStack]));

        $this->core = new Core($this->baseClient);
    }

    protected array $mockResponses = [
        'success' => [
            'responseMessage' => 'Request acknowledged succesfully.',
            'successful' => true,
            'status' => 'ACK_ACCEPTED',
            'responseCode' => '317',
        ],
        'failed' => [
            'responseMessage' => 'Required Service Parameter(s) [[source_paybill]] not supplied.',
            'responseCode' => '506',
            'status' => 'REQUIRED_PARAMS_MISSING',
        ],
        'invalid_creds' => [
            'responseMessage' => 'Invalid credentials passed for the client',
            'responseCode' => '313',
            'status' => 'INVALID_CLIENT_CREDENTIALS',
        ],
    ];
}
