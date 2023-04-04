<?php

namespace Kainiklas\LaravelStrictMode\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class MemoryHeap
{
    /**
     * Nothing to do here. Just pass-through.
     */
    public function handle($request, Closure $next)
    {
        return $next($request);
    }

    /**
     * This method is called after the response has been sent to the browser.
     * Log memory heap size in MB.
     */
    public function terminate($request, $response)
    {
        $heapsize = memory_get_peak_usage(true) / 1024 / 1024;

        if (
            config('strict-mode.log_memory_heap_size') &&
            $heapsize > config('strict-mode.log_memory_heap_size_threshold')
        ) {
            Log::warning('Memory heap size exceeded threshold.', [
                'threshold' => config('strict-mode.log_memory_heap_size_threshold'),
                'heapsize' => $heapsize.'[MB]',
            ]);
        }
    }
}
