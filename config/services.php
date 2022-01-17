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
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET','9354814e69233b45504025863b67428ce43ee5bc'),
    ],
    'onesignal' => [
        'app_id' => env('ONESIGNAL_APP_ID', '3a2df22c-63b5-49be-9c0f-91ef531191c7'),
        'rest_api_key' => env('ONESIGNAL_REST_API_KEY', 'ZmZiNDRkZjctNmE1OC00OWI1LTg2ODQtMzYyYThlZGRhMDQy')
    ],
    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

];
