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

    'vrchat' => [
        'username' => env('VRCHAT_USERNAME'),
        'password' => env('VRCHAT_PASSWORD'),
        'apikey' => env('VRCHAT_API_KEY', 'us-east-1'),
    ],

    'gmailapi' => [
        'client_id' => env('CLIENT_ID'),
        'project_id' => env('PROJECT_ID'),
        'auth_uri' => env('AUTH_URI'),
        'token_uri' => env('TOKEN_URI'),
        'auth_provider_x509_cert_url' => env('AUTH_PROVIDER_X509_CERT_URL'),
        'client_secret' => env('CLIENT_SECRET'),
        'redirect_uris' => [
            env('REDIRECT_URIS')
        ],
    ],
];