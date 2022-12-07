<?php

namespace Kainiklas\LaravelStrictMode\Tests;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kainiklas\LaravelStrictMode\LaravelStrictModeServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class BaseTestCase extends Orchestra
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

    protected function tearDown(): void
    {
        Model::handleLazyLoadingViolationUsing(null);
        Model::handleDiscardedAttributeViolationUsing(null);
        Model::handleMissingAttributeViolationUsing(null);
        parent::tearDown();
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
    }
}
