<?php

namespace Kainiklas\LaravelStrictMode\Tests;

use Kainiklas\LaravelStrictMode\LaravelStrictModeServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelStrictModeServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
    }
}
