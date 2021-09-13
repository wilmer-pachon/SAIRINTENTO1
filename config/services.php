<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => env('SES_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'facebook' => [
        'client_id' => env('841915706688884'),
        'client_secret' => env('6e094f65e0ac65a580e89a4b6d65b827'),
        'redirect' => Config('app.url') . '/login/facebook/callback'
    ],

    // 'facebook' => [
    //     'client_id' => '841915706688884',
    //     'client_secret' => '6e094f65e0ac65a580e89a4b6d65b827',
    //     'redirect' => 'http://localhost:8000/login/facebook/callback'
    // ]

];

// http://127.0.0.1:8000/main