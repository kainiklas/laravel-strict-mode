<?php

use Carbon\CarbonInterval;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

it('doesntLogsAWarningOnSlowRequest', function () {
    Log::shouldReceive('warning')
        ->never()
        ->withArgs(function ($message) {
            return strpos($message, 'A request took longer than the defined threshold.') !== false;
        });

    Route::get('test-route', fn () => 'ok');
    $request = Request::create('http://localhost/test-route');
    $response = new Response();
    $called = false;
    $kernel = resolve(Kernel::class);
    $kernel->whenRequestLifecycleIsLongerThan(CarbonInterval::seconds(1), function () use (&$called) {
        $called = true;
    });

    Carbon::setTestNow(Carbon::now());
    $kernel->handle($request);

    Carbon::setTestNow(Carbon::now()->addSeconds(5)->addMilliseconds(1));
    $kernel->terminate($request, $response);
});
