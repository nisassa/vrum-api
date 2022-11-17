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
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    /*
    |--------------------------------------------------------------------------
    | SDCMS encrypt settings
    |--------------------------------------------------------------------------
    |
    | These settings regulate the encryption settings when setting a password
    | on the API which isn't for brand new registrations.
    |
    */

    'sdcms_encrypt' => [
        'salt_length' => env('SDCMS_ENCRYPT_SALT_LENGTH', 16),
        'algorithm' => env('SDCMS_ENCRYPT_ALGORITHM', 'sha256'),
        'iterations' => env('SDCMS_ENCRYPT_ITERATIONS', 1024),
        'key_length' => env('SDCMS_ENCRYPT_KEY_LENGTH', 32),
    ],

];
