<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

it('logsAnInfoOnLongRunningDBQueries', function () {
    Log::shouldReceive('info')
        ->once()
        ->withArgs(function ($message) {
            return strpos($message, 'Database queries exceeded the defined threshold.') !== false;
        });

    /** @var Illuminate\Database\Connection */
    $connection = DB::connection();
    $connection->logQuery('xxxx', [], 900);
    $connection->logQuery('xxxx', [], 900);
    $connection->logQuery('xxxx', [], 900);
});

it('logsAnInfoOnLongRunningSingleDBQuery', function () {
    Log::shouldReceive('info')
        ->once()
        ->withArgs(function ($message) {
            return strpos($message, 'An individual database query exceeded the defined threshold.') !== false;
        });

    /** @var Illuminate\Database\Connection */
    $connection = DB::connection();
    $connection->logQuery('xxxx', [], 1001);
});
