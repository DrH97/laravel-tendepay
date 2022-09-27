<?php

namespace DrH\TendePay\Tests;

use DrH\TendePay\Library\Core;
use DrH\TendePay\TendePayServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Event;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    public Core $core;

    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'DrH\\TendePay\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );

        $this->core = App::make(Core::class);

        Event::fake();
    }

    protected function getPackageProviders($app): array
    {
        return [
            TendePayServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        $migration = include __DIR__.'/../database/migrations/create_tende_pay_requests_table.php.stub';
        $migration->up();

        $migration = include __DIR__.'/../database/migrations/create_tende_pay_callbacks_table.php.stub';
        $migration->up();
    }
}
