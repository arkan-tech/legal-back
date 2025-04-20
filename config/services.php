<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT'),
        'analytics' => [
            'property_id' => env('GOOGLE_ANALYTICS_PROPERTY_ID'),
            'streams' => [
                'web' => [
                    'measurement_id' => env('GOOGLE_ANALYTICS_WEB_MEASUREMENT_ID'),
                    'stream_id' => env('GOOGLE_ANALYTICS_WEB_STREAM_ID'),
                ],
                'android' => [
                    'app_id' => env('GOOGLE_ANALYTICS_ANDROID_APP_ID'),
                ],
                'ios' => [
                    'app_id' => env('GOOGLE_ANALYTICS_IOS_APP_ID'),
                ],
            ],
        ],
        'search_console' => [
            'site_url' => env('GOOGLE_SEARCH_CONSOLE_SITE_URL'),
        ],
    ]

];
