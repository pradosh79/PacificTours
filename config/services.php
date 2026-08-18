<?php

declare(strict_types=1);

return [

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key'    => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'ca-central-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Payment gateways
    |--------------------------------------------------------------------------
    | Keys live here; whether a gateway is *offered* to customers is an admin
    | setting (payment.stripe_enabled), so ops can switch a gateway off without
    | a deploy. PaymentGatewayManager checks both.
    */

    'stripe' => [
        'key'            => env('STRIPE_KEY'),
        'secret'         => env('STRIPE_SECRET'),
        'webhook_secret' => env('STRIPE_WEBHOOK_SECRET'),
        'api_version'    => '2024-06-20',
    ],

    'paypal' => [
        'mode'      => env('PAYPAL_MODE', 'sandbox'),
        'client_id' => env('PAYPAL_CLIENT_ID'),
        'secret'    => env('PAYPAL_SECRET'),
        'base_url'  => env('PAYPAL_MODE', 'sandbox') === 'live'
            ? 'https://api-m.paypal.com'
            : 'https://api-m.sandbox.paypal.com',
        'webhook_id' => env('PAYPAL_WEBHOOK_ID'),
    ],

    'google' => [
        'maps_key'    => env('GOOGLE_MAPS_KEY'),
        'analytics_id'=> env('GOOGLE_ANALYTICS_ID'),
        'recaptcha'   => [
            'site_key'   => env('RECAPTCHA_SITE_KEY'),
            'secret_key' => env('RECAPTCHA_SECRET_KEY'),
        ],
    ],
];
