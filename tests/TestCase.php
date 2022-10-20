<?php

namespace Kainiklas\LaravelStrictMode\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Kainiklas\LaravelStrictMode\LaravelStrictModeServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Kainiklas\\LaravelStrictMode\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelStrictModeServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_laravel-strict-mode_table.php.stub';
        $migration->up();
        */
    }
}
