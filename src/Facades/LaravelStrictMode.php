<?php

namespace Kainiklas\LaravelStrictMode\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Kainiklas\LaravelStrictMode\LaravelStrictMode
 */
class LaravelStrictMode extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Kainiklas\LaravelStrictMode\LaravelStrictMode::class;
    }
}
