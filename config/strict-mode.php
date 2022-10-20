<?php

// config for Kainiklas/LaravelStrictMode
return [

    /**
     * Throws Illuminate\Database\LazyLoadingViolationException if model is lazy loaded.
     * Exception is only thrown if log_lazy_loading is set to false.
     */
    'prevent_lazy_loading' => env(
        'PREVENT_LAZY_LOADING',
        true,
    ),

    /**
     * Lazy Loading violation is logged. No exception is thrown.
     * Only works, if prevent_lazy_loading is set to true.
     */
    'log_lazy_loading' => env(
        'LOG_LAZY_LOADING',
        env('APP_ENV') == 'production'
    ),

    /**
     * Prevent non-fillable attributes from being silently discarded.
     * Instead, throws Illuminate\Database\Eloquent\MassAssignmentException.
     *
     * correctness of app -> should be enabled in all environments
     */
    'prevent_silently_discarding_attributes' => env(
        'PREVENT_SILENTLY_DISCARDING_ATTRIBUTES',
        true
    ),

    /**
     * If activated an Illuminate\Database\Eloquent\MissingAttributeException
     * is thrown whenever an attribute is accessed which is not present in the model,
     * instead of falling back to NULL.
     *
     * correctness of app -> should be enabled in all environments
     */
    'prevent_accessing_missing_attributes' => env(
        'PREVENT_ACCESSING_MISSING_ATTRIBUTES',
        true
    ),

    /**
     * Logs a warning if a command runs longer than the specified threshold.
     * Threshold is speficied in milliseconds [ms].
     */
    'long_running_command_threshold' => env(
        'LONG_RUNNING_COMMAND_THRESHOLD',
        5000 // [ms]
    ),

    /**
     * Logs a warning if a HTTP request runs longer than the specified threshold.
     * Threshold is speficied in milliseconds [ms].
     */
    'long_running_request_threshold' => env(
        'LONG_RUNNING_REQUEST_THRESHOLD',
        5000 // [ms]
    ),

    /**
     * Logs a warning if a DB connection runs longer than the specified threshold.
     * Threshold is speficied in milliseconds [ms].
     */
    'long_running_total_db_query_threshold' => env(
        'LONG_RUNNING_TOTAL_DB_QUERY_THRESHOLD',
        2000 // [ms]
    ),

    /**
     * Logs a warning if a single DB Query runs longer than the specified threshold.
     * Threshold is speficied in milliseconds [ms].
     */
    'long_running_single_db_query_threshold' => env(
        'LONG_RUNNING_SINGLE_DB_QUERY_THRESHOLD',
        1000 // [ms]
    ),

];
