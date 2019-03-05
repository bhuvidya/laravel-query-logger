<?php

return [
    /*
    |--------------------------------------------------------------------------
    | There are different ways to turn this logger on.
    |--------------------------------------------------------------------------
    */

    'on'          => env('QUERY_LOGGER_ON', false),
    'env'         => preg_split('/[\s,]+/', env('QUERY_LOGGER_ENV', 'local staging'), -1, PREG_SPLIT_NO_EMPTY),
    'query_param' => env('QUERY_LOGGER_PARAM', false),
    'all'         => env('QUERY_LOGGER_ALL', false),

    /*
    |--------------------------------------------------------------------------
    | Set a minimum time (ms) before logging queries. 0 means log all.
    |--------------------------------------------------------------------------
    */

    'min_time_ms' => env('QUERY_LOGGER_MIN_TIME', 0),

    /*
    |--------------------------------------------------------------------------
    | Logging options.
    |--------------------------------------------------------------------------
    */

    'log' => [
        'on'      => env('QUERY_LOGGER_EMIT_LOG', true),
        'level'   => env('QUERY_LOGGER_EMIT_LEVEL', 'debug'),
        'channel' => env('QUERY_LOGGER_EMIT_CHANNEL', 'default'),
        'stack'   => preg_split('/[\s,]+/', env('QUERY_LOGGER_EMIT_STACK', 'local staging'), -1, PREG_SPLIT_NO_EMPTY),
        'prefix'  => env('QUERY_LOGGER_EMIT_PREFIX', ''),
    ],

    'dump_server' => env('QUERY_LOGGER_EMIT_DUMP_SERVER', false),

    /*
    |--------------------------------------------------------------------------
    | Service instance "name".
    |--------------------------------------------------------------------------
    */
    'instance' => env('QUERY_LOGGER_INSTANCE', 'bhuvidya.query_logger'),

    /*
    |--------------------------------------------------------------------------
    | You can elect to register an alias for the facade automatically, and give
    | it your own custom class name. Set to false to not register.
    |--------------------------------------------------------------------------
    */
    'facade' => env('QUERY_LOGGER_FACADE', 'QueryLogger'),
];
