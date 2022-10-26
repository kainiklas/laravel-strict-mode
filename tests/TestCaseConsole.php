<?php

namespace Kainiklas\LaravelStrictMode\Tests;

use Kainiklas\LaravelStrictMode\LaravelStrictModeServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCaseConsole extends Orchestra
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

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('app.debug', 'true');
    }
}
