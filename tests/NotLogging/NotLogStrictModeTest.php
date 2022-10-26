<?php

use Illuminate\Support\Facades\Log;
use Kainiklas\LaravelStrictMode\Tests\Mocks\Model1;

it('doesntLogsAWarningOnLazyLoading', function () {
    Log::shouldReceive('warning')
        ->never()
        ->withArgs(function ($message) {
            return strpos($message, 'Attempted to lazy load') !== false;
        });

    try {
        Model1::create();
        Model1::create();

        $models = Model1::get();
        $models[0]->modelTwos;
    } catch (Exception $e) {
    } finally {
    }
});

it('doesntLogsAWarningOnMissingAttribute', function () {
    Log::shouldReceive('warning')
        ->never()
        ->withArgs(function ($message) {
            return strpos($message, 'Attempted to access') !== false;
        });

    try {
        Model1::create();
        Model1::create();

        $models = Model1::get();
        $models[0]->this_attribute_does_not_exist;
    } catch (Exception $e) {
    }
});

it('doesntLogsAWarningOnMissingFillable', function () {
    Log::shouldReceive('warning')
        ->never()
        ->withArgs(function ($message) {
            return strpos($message, 'Attempted to mass assign') !== false;
        });

    try {
        Model1::create();
        Model1::create([
            'non_fillable_attribute' => 'test',
        ]);
    } catch (Exception $e) {
    }
});
