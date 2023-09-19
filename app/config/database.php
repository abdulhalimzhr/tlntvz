<?php

return $config = [
    'driver'    => env('DB_DRIVER', 'mysql'),
    'host'      => env('DB_HOST', 'mariadb'),
    'database'  => env('DB_DATABASE', 'default'),
    'username'  => env('DB_USERNAME', 'default'),
    'password'  => env('DB_PASSWORD', 'secret'),
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
];
