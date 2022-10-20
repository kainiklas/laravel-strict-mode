<?php

namespace Kainiklas\LaravelStrictMode\Commands;

use Illuminate\Console\Command;

class LaravelStrictModeCommand extends Command
{
    public $signature = 'laravel-strict-mode';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
