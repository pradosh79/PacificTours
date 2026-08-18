<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Domain configuration
    |--------------------------------------------------------------------------
    | Values that belong to the business rather than the environment. Anything a
    | non-developer should be able to change lives in Settings (database) and
    | overrides these defaults through the setting() helper.
    */

    'company' => [
        'name'    => env('COMPANY_NAME', 'Pacific Tours Canada'),
        'email'   => env('COMPANY_EMAIL', 'info@pacifictours.ca'),
        'phone'   => env('COMPANY_PHONE'),
        'address' => env('COMPANY_ADDRESS'),
    ],

    'currency' => [
        'default' => env('DEFAULT_CURRENCY', 'CAD'),
        'symbols' => [
            'CAD' => '$',
            'USD' => 'US$',
            'EUR' => '€',
            'GBP' => '£',
        ],
    ],

    'prefixes' => [
        'booking' => 'PT',
        'invoice' => 'INV',
        'ticket'  => 'TKT',
        'tour'    => 'PT-T',
    ],

    'booking' => [
        'unpaid_ttl_hours'      => env('BOOKING_UNPAID_TTL', 48),
        'default_cutoff_hours'  => 48,
        'max_travellers'        => 60,
        'reminder_days_before'  => 3,
        'balance_reminder_days' => [30, 14, 7],
    ],

    'gateways' => [
        'stripe'        => App\Services\Payment\StripeGateway::class,
        'paypal'        => App\Services\Payment\PayPalGateway::class,
        'manual'        => App\Services\Payment\ManualGateway::class,
        'cash'          => App\Services\Payment\ManualGateway::class,
        'bank_transfer' => App\Services\Payment\ManualGateway::class,
    ],

    'uploads' => [
        'disk'            => env('UPLOAD_DISK', 'public'),
        'max_image_kb'    => 4096,
        'allowed_images'  => ['jpg', 'jpeg', 'png', 'webp'],
        'allowed_docs'    => ['pdf'],
    ],

    'cache_ttl' => [
        'home'      => 10 * 60,
        'facets'    => 60 * 60,
        'dashboard' => 2 * 60,
        'tours'     => 15 * 60,
    ],

    'seo' => [
        'default_title'       => 'Pacific Tours Canada · Guided tours across British Columbia and beyond',
        'default_description' => 'Small-group and private guided tours departing from Vancouver, Victoria and Whistler.',
        'og_image'            => 'images/og-default.jpg',
        'twitter_handle'      => '@pacifictours',
    ],
];
