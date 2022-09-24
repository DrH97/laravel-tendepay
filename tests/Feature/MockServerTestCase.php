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

    public Core $core;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mock = new MockHandler();

        $handlerStack = HandlerStack::create($this->mock);
        $this->baseClient = new BaseClient(new Client(['handler' => $handlerStack]));

        $this->core = new Core($this->baseClient);
    }
}
