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
use Kainiklas\LaravelStrictMode\Http\Middleware\MemoryHeap;
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
        // strict mode features
        $this->handleLazyLoading();
        $this->handlePreventSilentlyDiscardingAttributes();
        $this->handlePreventAccessingMissingAttributes();

        $this->handleLongRunningDBQueries();
        $this->handleSlowCommands();
        $this->handleSlowRequests();

        $kernel = app(HttpKernel::class);
        $kernel->pushMiddleware(MemoryHeap::class);
    }

    /**
     * Reference: https://github.com/laravel/framework/pull/37363
     */
    private function handleLazyLoading()
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

    /**
     * References:
     *   https://github.com/laravel/framework/pull/44664
     *   https://github.com/laravel/framework/pull/43893
     */
    private function handlePreventSilentlyDiscardingAttributes()
    {
        Model::preventSilentlyDiscardingAttributes(config('strict-mode.prevent_silently_discarding_attributes'));

        if (config('strict-mode.log_prevent_silently_discarding_attributes')) {
            Model::handleDiscardedAttributeViolationUsing(function (Model $model, $keys) {
                $class = get_class($model);
                $attributes = implode(', ', $keys);

                Log::warning("Attempted to mass assign [{$attributes}] on [{$class}].");
            });
        }
    }

    /**
     * References:
     *   https://github.com/laravel/framework/pull/44664
     *   https://github.com/laravel/framework/pull/44283
     */
    private function handlePreventAccessingMissingAttributes()
    {
        Model::preventAccessingMissingAttributes(config('strict-mode.prevent_accessing_missing_attributes'));

        if (config('strict-mode.log_prevent_accessing_missing_attributes')) {
            Model::handleMissingAttributeViolationUsing(function (Model $model, $attribute) {
                $class = get_class($model);

                Log::warning("Attempted to access [{$attribute}] on model [{$class}].");
            });
        }
    }

    /**
     * Reference: https://github.com/laravel/framework/pull/42744
     */
    private function handleLongRunningDBQueries()
    {
        // Long Running DB Query (Total)
        if (config('strict-mode.log_long_running_total_db_query')) {
            DB::whenQueryingForLongerThan(
                config('strict-mode.log_long_running_total_db_query_threshold'),
                function (Connection $connection) {
                    Log::info('Database queries exceeded the defined threshold.', [
                        'connection' => $connection->getName(),
                        'duration' => $connection->totalQueryDuration().'[ms]',
                        'threshold' => config('strict-mode.log_long_running_total_db_query_threshold').'[ms]',
                    ]);
                }
            );
        }

        // Long Running DB Query (Single)
        if (config('strict-mode.log_long_running_single_db_query')) {
            DB::listen(function ($query) {
                if ($query->time > config('strict-mode.log_long_running_single_db_query_threshold')) {
                    Log::info('An individual database query exceeded the defined threshold.', [
                        'sql' => $query->sql,
                        'duration' => $query->time.'[ms]',
                        'threshold' => config('strict-mode.log_long_running_single_db_query_threshold').'[ms]',
                    ]);
                }
            });
        }
    }

    /**
     * Reference: https://github.com/laravel/framework/pull/44125
     */
    private function handleSlowCommands()
    {
        if (! config('strict-mode.log_long_running_command')) {
            return;
        }

        if ($this->app->runningInConsole()) {
            $this->app[ConsoleKernel::class]->whenCommandLifecycleIsLongerThan(
                config('strict-mode.log_long_running_command_threshold'),
                function (Carbon $startedAt, InputInterface $input, $status) {
                    Log::warning('A command took longer than the defined threshold.', [
                        'command' => $input->getArgument('command'),
                        'duration' => $startedAt->floatDiffInSeconds() * 1000 .'[ms]',
                        'threshold' => config('strict-mode.log_long_running_command_threshold').'[ms]',
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
        if (! config('strict-mode.log_long_running_request')) {
            return;
        }

        if (! $this->app->runningInConsole() || $this->app->runningUnitTests()) {
            $this->app[HttpKernel::class]->whenRequestLifecycleIsLongerThan(
                config('strict-mode.log_long_running_request_threshold'),
                function (Carbon $startedAt, Request $request, Response $response) {
                    Log::warning('A request took longer than the defined threshold.', [
                        'user' => $request->user()?->id,
                        'url' => $request->fullUrl(),
                        'duration' => $startedAt->floatDiffInSeconds().'[s]',
                        'threshold' => config('strict-mode.log_long_running_request_threshold').'[ms]',
                    ]);
                }
            );
        }
    }
}
