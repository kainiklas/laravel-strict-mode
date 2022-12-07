<?php

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Input\StringInput;

it('doesntLogsLongRunningCommand', function () {
    Log::shouldReceive('warning')
            ->never();

    Artisan::command('longRunningCommand', fn () => null);

    $kernel = resolve(Kernel::class);

    Carbon::setTestNow(Carbon::now());
    $input = new StringInput('longRunningCommand');
    $kernel->handle($input);

    Carbon::setTestNow(Carbon::now()->addSeconds(5)->addMilliseconds(1));
    $kernel->terminate($input, 21);
});
