<?php

namespace Kainiklas\LaravelStrictMode;

use Illuminate\Contracts\Console\Kernel as ConsoleKernel;
use Illuminate\Contracts\Http\Kernel as HttpKernel;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Symfony\Component\Console\Input\InputInterface;

class LaravelStrictModeServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-strict-mode')
            ->hasConfigFile();
    }

    public function boot()
    {
        Model::preventSilentlyDiscardingAttributes(config('strict-mode.prevent_silently_discarding_attributes'));
        Model::preventAccessingMissingAttributes(config('strict-mode.prevent_accessing_missing_attributes'));

        $this->lazyLoading();

        $this->handleLongRunningDBQueries();
        $this->handleSlowCommands();
        $this->handleSlowRequests();
    }

    private function lazyLoading()
    {
        // lazy loading => avoid N+1 queries and throw exception
        Model::preventLazyLoading(config('strict-mode.prevent_lazy_loading'));

        // lazy loading => log
        if (config('strict-mode.log_lazy_loading')) {
            Model::handleLazyLoadingViolationUsing(function ($model, $relation) {
                $class = get_class($model);

                Log::warning("Attempted to lazy load [{$relation}] on model [{$class}].");
            });
        }
    }

    private function handleLongRunningDBQueries()
    {
        // Long Running DB Query (Total)
        DB::whenQueryingForLongerThan(
            config('strict-mode.long_running_total_db_query_threshold'),
            function (Connection $connection) {
                Log::warning('Database queries exceeded the defined threshold.', [
                    'connection' => $connection->getName(),
                    'duration' => $connection->totalQueryDuration().'[ms]',
                    'threshold' => config('strict-mode.long_running_total_db_query_threshold').'[ms]',
                ]);
            }
        );

        // Long Running DB Query (Single)
        DB::listen(function ($query) {
            if ($query->time > config('strict-mode.long_running_total_db_query_threshold')) {
                Log::warning('An individual database query exceeded the defined threshold.', [
                    'sql' => $query->sql,
                    'duration' => $query->time.'[ms]',
                    'threshold' => config('strict-mode.long_running_total_db_query_threshold').'[ms]',
                ]);
            }
        });
    }

    /**
     * Reference: https://github.com/laravel/framework/pull/44125
     */
    private function handleSlowCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->app[ConsoleKernel::class]->whenCommandLifecycleIsLongerThan(
                config('strict-mode.long_running_command_threshold'),
                function (Carbon $startedAt, InputInterface $input, $status) {
                    Log::warning('A command took longer than the defined threshold.', [
                        'command' => $input->getArgument('command'),
                        'duration' => $startedAt->floatDiffInSeconds() * 1000 .'[ms]',
                        'threshold' => config('strict-mode.long_running_request_threshold').'[ms]',
                    ]);
                }
            );
        }
    }

    /**
     * Reference: https://github.com/laravel/framework/pull/44122
     */
    private function handleSlowRequests()
    {
        if (! $this->app->runningInConsole()) {
            $this->app[HttpKernel::class]->whenRequestLifecycleIsLongerThan(
                config('strict-mode.long_running_request_threshold'),
                function (Carbon $startedAt, Request $request, Response $response) {
                    Log::warning('A request took longer than the defined threshold.', [
                        'user' => $request->user()?->id,
                        'url' => $request->fullUrl(),
                        'duration' => $startedAt->floatDiffInSeconds().'[s]',
                        'threshold' => config('strict-mode.long_running_request_threshold').'[ms]',
                    ]);
                }
            );
        }
    }
}
