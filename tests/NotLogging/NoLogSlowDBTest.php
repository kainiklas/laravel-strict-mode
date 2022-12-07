<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

it('doesntLogsAnInfoOnLongRunningDBQueries', function () {
    Log::shouldReceive('info')
        ->never();

    /** @var Illuminate\Database\Connection */
    $connection = DB::connection();
    $connection->logQuery('xxxx', [], 900);
    $connection->logQuery('xxxx', [], 900);
    $connection->logQuery('xxxx', [], 900);
});

it('doesntLogsAnInfoOnLongRunningSingleDBQuery', function () {
    Log::shouldReceive('info')
        ->never();

    /** @var Illuminate\Database\Connection */
    $connection = DB::connection();
    $connection->logQuery('xxxx', [], 1001);
});
