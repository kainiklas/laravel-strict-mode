<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Kainiklas\LaravelStrictMode\Tests\TestCaseConsole;
use Kainiklas\LaravelStrictMode\Tests\TestCaseException;
use Kainiklas\LaravelStrictMode\Tests\TestCaseLogging;
use Kainiklas\LaravelStrictMode\Tests\TestCaseNotLogging;

uses(TestCaseException::class, RefreshDatabase::class)->in('Exception');
uses(TestCaseLogging::class, RefreshDatabase::class)->in('Logging');
uses(TestCaseNotLogging::class, RefreshDatabase::class)->in('NotLogging');
uses(TestCaseConsole::class)->in('Console');
