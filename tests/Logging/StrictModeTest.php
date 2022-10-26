<?php

use Illuminate\Support\Facades\Log;
use Kainiklas\LaravelStrictMode\Tests\Mocks\Model1;

it('logsAWarningOnLazyLoading', function () {
    Log::shouldReceive('warning')
        ->once()
        ->withArgs(function ($message) {
            return strpos($message, 'Attempted to lazy load') !== false;
        });

    Model1::create();
    Model1::create();

    $models = Model1::get();
    $models[0]->modelTwos;
});

it('logsAWarningOnMissingAttribute', function () {
    Log::shouldReceive('warning')
        ->once()
        ->withArgs(function ($message) {
            return strpos($message, 'Attempted to access') !== false;
        });

    Model1::create();
    Model1::create();

    $models = Model1::get();
    $models[0]->this_attribute_does_not_exist;
});

it('logsAWarningOnMissingFillable', function () {
    Log::shouldReceive('warning')
        ->once()
        ->withArgs(function ($message) {
            return strpos($message, 'Attempted to mass assign') !== false;
        });

    Model1::create([
        'non_fillable_attribute' => 'test',
    ]);
});
