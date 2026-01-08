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

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'postback' => [
        'shared_secret' => env('ADGEM_POSTBACK_SHARED_SECRET'),
    ],

    'adgem' => [
        'base_url' => env('ADGEM_BASE_URL', 'https://api.adgem.com/v1'),
        'offers_path' => env('ADGEM_OFFERS_PATH', '/offers'),
        'publisher_id' => env('ADGEM_PUBLISHER_ID'),
        'api_key' => env('ADGEM_API_KEY'),
        'secret' => env('ADGEM_SECRET'),
        'timeout' => env('ADGEM_TIMEOUT', 10),
    ],

];
