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
        'postback_secret' => env('ADGEM_POSTBACK_SHARED_SECRET'),
        'postback_field_map' => [
            'transaction_id' => env('ADGEM_POSTBACK_TRANSACTION_ID_FIELD', 'transaction_id'),
            'offer_id' => env('ADGEM_POSTBACK_OFFER_ID_FIELD', 'offer_id'),
            'goal_id' => env('ADGEM_POSTBACK_GOAL_ID_FIELD', 'goal_id'),
            'payout' => env('ADGEM_POSTBACK_PAYOUT_FIELD', 'payout'),
            'click_datetime' => env('ADGEM_POSTBACK_CLICK_DATETIME_FIELD', 'click_datetime'),
        ],
    ],

    'theoremreach' => [
        'base_url' => env('THEOREMREACH_BASE_URL', 'https://api.theoremreach.com'),
        'offers_path' => env('THEOREMREACH_OFFERS_PATH', '/api/v1/offers'),
        'api_key' => env('THEOREMREACH_API_KEY'),
        'secret' => env('THEOREMREACH_SECRET'),
        'timeout' => env('THEOREMREACH_TIMEOUT', 10),
        'postback_secret' => env('THEOREMREACH_POSTBACK_SHARED_SECRET'),
        'postback_field_map' => [
            'transaction_id' => env('THEOREMREACH_POSTBACK_TRANSACTION_ID_FIELD', 'transaction_id'),
            'offer_id' => env('THEOREMREACH_POSTBACK_OFFER_ID_FIELD', 'offer_id'),
            'goal_id' => env('THEOREMREACH_POSTBACK_GOAL_ID_FIELD', 'goal_id'),
            'payout' => env('THEOREMREACH_POSTBACK_PAYOUT_FIELD', 'payout'),
            'click_datetime' => env('THEOREMREACH_POSTBACK_CLICK_DATETIME_FIELD', 'click_datetime'),
        ],
    ],

];
