<?php

namespace Kainiklas\LaravelStrictMode;

use Kainiklas\LaravelStrictMode\Commands\LaravelStrictModeCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelStrictModeServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-strict-mode')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-strict-mode_table')
            ->hasCommand(LaravelStrictModeCommand::class);
    }
}
