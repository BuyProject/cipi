<?php

return [

    // Panel Credential
    'username'          => env('CIPI_USERNAME', 'administrator'),
    'password'          => env('CIPI_PASSWORD', '12345678'),

    // JWT Settings
    'jwt_secret'        => env('JWT_SECRET', env('APP_KEY')),
    'jwt_access'        => env('JWT_ACCESS', 900),
    'jwt_refresh'       => env('JWT_REFRESH', 14400),

    // Custom Vars
    'name'              => env('CIPI_NAME', 'BuyCloud CP'),
    'website'           => env('CIPI_WEBSITE', 'https://buycloud.id'),
    'activesetupcount'  => env('CIPI_ACTIVESETUPCOUNT', 'https://service.cipi.sh/setupcount'),
    'documentation'     => env('CIPI_DOCUMENTATION', 'https://cipi.sh/docs.html'),
    'app'               => env('CIPI_APP', 'https://play.google.com/store/apps/details?id=it.christiangiupponi.cipi'),

    // Global Settings
    'users_prefix'      => env('CIPI_USERS_PREFIX', 'cp'),
    'phpvers'           => ['8.1', '8.0', '7.4', '7.3', '7.2'],
    'services'          => ['nginx', 'php', 'mysql', 'redis', 'supervisor'],
    'default_php'       => '8.0',

];
