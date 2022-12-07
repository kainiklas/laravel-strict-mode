<?php

use Kainiklas\LaravelStrictMode\Tests\TestCaseException;
use Kainiklas\LaravelStrictMode\Tests\TestCaseLogging;
use Kainiklas\LaravelStrictMode\Tests\TestCaseNotLogging;

uses(TestCaseException::class)
  // ->beforeEach(fn() => dump('beforeException'))
->in('Exception');

uses(TestCaseLogging::class)
// ->beforeEach(fn() => dump('beforeLogging'))
->in('Logging');

uses(TestCaseNotLogging::class)
// ->beforeEach(fn() => dump('beforeNotLogging'))
->in('NotLogging');

uses(TestCaseLogging::class)
// ->beforeEach(fn() => dump('beforeConsole'))
->in('Console');
