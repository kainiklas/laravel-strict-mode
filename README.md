# Laravel package which enables and configures common safety methods

[![Latest Version on Packagist](https://img.shields.io/packagist/v/kainiklas/laravel-strict-mode.svg?style=flat-square)](https://packagist.org/packages/kainiklas/laravel-strict-mode)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/kainiklas/laravel-strict-mode/run-tests?label=tests)](https://github.com/kainiklas/laravel-strict-mode/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/kainiklas/laravel-strict-mode/Fix%20PHP%20code%20style%20issues?label=code%20style)](https://github.com/kainiklas/laravel-strict-mode/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/kainiklas/laravel-strict-mode.svg?style=flat-square)](https://packagist.org/packages/kainiklas/laravel-strict-mode)

Enables the following safety mechanisms in your Laravel project:

- Prevent Lazy Loading (N+1 prevention)
- Partially hydrated model protection
- Attribute typos and renamed columns
- Mass assignment protection
- Model strictness
- Long-running command & request monitoring


## Installation

You can install the package via composer:

```bash
composer require kainiklas/laravel-strict-mode
```

Optionally, you can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-strict-mode-config"
```

This is the contents of the published config file. 
The configuration can be adapted using environment variables.

```php
return [

    /**
     * Throw exception if model is lazy loaded.
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
     * Instead, throw an Illuminate\Database\Eloquent\MassAssignmentException.
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
```

## Usage



## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Kai Niklas](https://github.com/kainiklas)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.