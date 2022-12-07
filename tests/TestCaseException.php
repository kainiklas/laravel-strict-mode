<?php

namespace Kainiklas\LaravelStrictMode\Tests;

class TestCaseException extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        putenv('LOG_LAZY_LOADING=false');
        putenv('LOG_PREVENT_SILENTLY_DISCARDING_ATTRIBUTES=false');
        putenv('LOG_PREVENT_ACCESSING_MISSING_ATTRIBUTES=false');

        return parent::getPackageProviders($app);
    }
}
