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

    'siakad' => [
        // Server SIAKAD hanya melayani HTTP. Karena situs kita HTTPS, semua
        // request dari browser ke host ini diblokir (mixed content). Maka
        // trafik browser disalurkan lewat /siakad-proxy/* yang di-forward
        // server-side oleh SiakadProxyController ke target di bawah ini.
        'target' => rtrim(env('SIAKAD_PROXY_TARGET', 'http://103.219.248.108'), '/'),
    ],

];
