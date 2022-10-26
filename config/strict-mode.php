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
     * Only works, if prevent_lazy_loading is true.
     */
    'log_lazy_loading' => env(
        'LOG_LAZY_LOADING',
        env('APP_ENV') == 'production'
    ),

    /**
     * Prevent non-fillable attributes from being silently discarded.
     * Instead, throws Illuminate\Database\Eloquent\MassAssignmentException.
     * Exception is only thrown if log_prevent_silently_discarding_attributes is false.
     */
    'prevent_silently_discarding_attributes' => env(
        'PREVENT_SILENTLY_DISCARDING_ATTRIBUTES',
        true
    ),

    /**
     * Log warning Illuminate\Database\Eloquent\MassAssignmentException
     * instead of throwing the exception.
     * Only works if prevent_silently_discarding_attributes is true.
     */
    'log_prevent_silently_discarding_attributes' => env(
        'LOG_PREVENT_SILENTLY_DISCARDING_ATTRIBUTES',
        false
    ),

    /**
     * If activated an Illuminate\Database\Eloquent\MissingAttributeException
     * is thrown whenever an attribute is accessed which is not present in the model,
     * instead of falling back to NULL.
     *
     * Exception is only thrown if log_prevent_accessing_missing_attributes is false.
     */
    'prevent_accessing_missing_attributes' => env(
        'PREVENT_ACCESSING_MISSING_ATTRIBUTES',
        true
    ),

    /**
     * Log warning Illuminate\Database\Eloquent\MissingAttributeException
     * instead of throwing the exception.
     * Only works if prevent_accessing_missing_attributes is true.
     */
    'log_prevent_accessing_missing_attributes' => env(
        'LOG_PREVENT_ACCESSING_MISSING_ATTRIBUTES',
        false
    ),

    /**
     * Logs a warning if a command runs longer than the specified threshold.
     */
    'log_long_running_command' => env(
        'LOG_LONG_RUNNING_COMMAND',
        true
    ),

    /**
     * Threshold for long running command in milliseconds [ms].
     */
    'log_long_running_command_threshold' => env(
        'LOG_LONG_RUNNING_COMMAND_THRESHOLD',
        5000 // [ms]
    ),

    /**
     * Logs a warning if a HTTP request runs longer than the specified threshold.
     */
    'log_long_running_request' => env(
        'LOG_LONG_RUNNING_REQUEST',
        true
    ),

    /**
     * Threshold for long running HTTP request in milliseconds [ms].
     */
    'log_long_running_request_threshold' => env(
        'LOG_LONG_RUNNING_REQUEST_THRESHOLD',
        5000 // [ms]
    ),

    /**
     * Logs a warning if a DB connection runs longer than the specified threshold.
     */
    'log_long_running_total_db_query' => env(
        'LOG_LONG_RUNNING_TOTAL_DB_QUERY',
        true
    ),

    /**
     * Threshold for long running db connection in milliseconds [ms].
     */
    'log_long_running_total_db_query_threshold' => env(
        'LOG_LONG_RUNNING_TOTAL_DB_QUERY_THRESHOLD',
        2000 // [ms]
    ),

    /**
     * Logs a warning if a single DB Query runs longer than the specified threshold.
     */
    'log_long_running_single_db_query' => env(
        'LOG_LONG_RUNNING_SINGLE_DB_QUERY',
        true
    ),

    /**
     * Threshold for long running single DB Query in milliseconds [ms].
     */
    'log_long_running_single_db_query_threshold' => env(
        'LOG_LONG_RUNNING_SINGLE_DB_QUERY_THRESHOLD',
        1000 // [ms]
    ),

];
