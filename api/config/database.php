<?php

use Illuminate\Support\Str;

return [

    'default' => env('DB_CONNECTION', 'innyx-db'),

    'connections' => [

        'innyx-db' => [
            'driver'   => 'mysql',
            'host'     => env('DB_HOST', 'mysql'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'innyx_db'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', 'root'),
            'charset'  => 'utf8',
            'prefix'   => '',
            'schema'   => 'public',
        ],

        'innyx-test-db' => [
            'driver'   => 'mysql',
            'host'     => env('DB_HOST', 'mysql'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'innyx_test_db'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', 'root'),
            'charset'  => 'utf8',
            'prefix'   => '',
            'schema'   => 'public',
        ],

    ],

    'migrations' => 'migrations',


    'redis' => [

        'client' => env('REDIS_CLIENT', 'phpredis'),

        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_').'_database_'),
        ],

        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
        ],

        'cache' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_CACHE_DB', '1'),
        ],

    ],

];
