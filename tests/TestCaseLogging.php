<?php

namespace Kainiklas\LaravelStrictMode\Tests;

class TestCaseLogging extends BaseTestCase
{

    protected function getPackageProviders($app)
    {
        putenv('LOG_LAZY_LOADING=true');
        putenv('LOG_PREVENT_SILENTLY_DISCARDING_ATTRIBUTES=true');
        putenv('LOG_PREVENT_ACCESSING_MISSING_ATTRIBUTES=true');

        putenv('LOG_LONG_RUNNING_COMMAND=true');
        putenv('LOG_LONG_RUNNING_REQUEST=true');
        putenv('LOG_LONG_RUNNING_TOTAL_DB_QUERY=true');
        putenv('LOG_LONG_RUNNING_SINGLE_DB_QUERY=true');

        return parent::getPackageProviders($app);
    }

}
