<?php

namespace Kainiklas\LaravelStrictMode\Tests;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kainiklas\LaravelStrictMode\LaravelStrictModeServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCaseLogging extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('test_model1', function (Blueprint $table) {
            $table->increments('id');
        });

        Schema::create('test_model2', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('model_1_id');
        });
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelStrictModeServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        config()->set('app.debug', 'true');
        config()->set('database.default', 'testbench');
        config()->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        config()->set('strict-mode.log_lazy_loading', true);
        config()->set('strict-mode.log_prevent_silently_discarding_attributes', true);
        config()->set('strict-mode.log_prevent_accessing_missing_attributes', true);
    }
}
