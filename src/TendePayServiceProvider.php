<?php

namespace DrH\TendePay;

use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class TendePayServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-tendepay')
            ->hasConfigFile()
            ->hasMigrations(['create_tende_pay_requests_table', 'create_tende_pay_callbacks_table'])
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->askToRunMigrations();
            });
    }

    public function boot(): TendePayServiceProvider|static
    {
        parent::boot();

        $this->requireHelperScripts();

        return $this;
    }

    private function requireHelperScripts()
    {
        $files = glob(__DIR__.'/Support/*.php');
        foreach ($files as $file) {
            include_once $file;
        }
    }
}
