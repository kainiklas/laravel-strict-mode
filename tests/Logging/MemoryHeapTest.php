<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use function Pest\Faker\fake;

it('logsAWarningWhenMemoryHeapIsTooHigh', function () {
    Log::shouldReceive('warning')
        ->once()
        ->withArgs(function ($message) {
            return strpos($message, 'Memory heap size exceeded threshold.') !== false;
        });

    $dummy = [];
    for ($i = 0; $i < 50000; $i++) {
        array_push($dummy, fake()->sentence());
    }

    $test = implode(', ', $dummy);

    Route::get('test-route', fn () => 'ok');
    $request = Request::create('http://localhost/test-route', $content = $test);
    $kernel = resolve(Kernel::class);
    $kernel->handle($request);
    $response = new Response();
    $kernel->terminate($request, $response);

    unset($test);
    unset($dummy);
})->skip();
