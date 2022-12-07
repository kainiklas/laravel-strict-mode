<?php

namespace Kainiklas\LaravelStrictMode\Tests;

class TestCaseNotLogging extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // $this->refreshApplication();
    }

    protected function getPackageProviders($app)
    {
        putenv('LOG_LAZY_LOADING=false');
        putenv('LOG_PREVENT_SILENTLY_DISCARDING_ATTRIBUTES=false');
        putenv('LOG_PREVENT_ACCESSING_MISSING_ATTRIBUTES=false');

        putenv('LOG_LONG_RUNNING_COMMAND=false');
        putenv('LOG_LONG_RUNNING_REQUEST=false');
        putenv('LOG_LONG_RUNNING_TOTAL_DB_QUERY=false');
        putenv('LOG_LONG_RUNNING_SINGLE_DB_QUERY=false');

        return parent::getPackageProviders($app);
    }
}
