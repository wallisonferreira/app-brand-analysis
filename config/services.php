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

    // other configurations...
    'openai' => [
        'secret' => env('OPENAI_API_KEY'),
    ],

    'azure' => [
        'endpoint_url' => env('AZURE_ENDPOINT_URL'),
        'openai_api_key' => env('AZURE_OPENAI_API_KEY'),
        'deployment_name' => env('AZURE_DEPLOYMENT_NAME'),
        'search_endpoint' => env('AZURE_SEARCH_ENDPOINT'),
        'search_key' => env('AZURE_SEARCH_KEY'),
        'search_index' => env('AZURE_SEARCH_INDEX'),
        'embedding_endpoint' => env('AZURE_EMBEDDING_ENDPOINT'),
        'access_token' => env('AZURE_ACCESS_TOKEN'),
    ],
];
