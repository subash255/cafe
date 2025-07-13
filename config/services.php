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
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'esewa' => [
        'merchant_code' => env('ESEWA_MERCHANT_CODE', 'EPAYTEST'),
        'secret_key' => env('ESEWA_SECRET_KEY', '8gBm/:&EnhH.1/q'),
        'base_url' => env('ESEWA_BASE_URL', 'https://rc-epay.esewa.com.np/api/epay/main/v2/form'),
        'status_check_url' => env('ESEWA_STATUS_CHECK_URL', 'https://rc.esewa.com.np/api/epay/transaction/status/'),
        'success_url' => env('ESEWA_SUCCESS_URL'),
        'failure_url' => env('ESEWA_FAILURE_URL'),
    ],
];
