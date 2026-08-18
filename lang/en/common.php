<?php

declare(strict_types=1);

return [
    'actions' => [
        'save' => 'Save', 'cancel' => 'Cancel', 'delete' => 'Delete', 'edit' => 'Edit',
        'create' => 'Create', 'search' => 'Search', 'filter' => 'Filter', 'export' => 'Export',
        'back' => 'Back', 'continue' => 'Continue', 'confirm' => 'Confirm', 'close' => 'Close',
    ],
    'nav' => [
        'home' => 'Home', 'tours' => 'Tours', 'destinations' => 'Destinations',
        'blog' => 'Blog', 'about' => 'About us', 'contact' => 'Contact',
        'account' => 'My account', 'bookings' => 'My bookings', 'wishlist' => 'Saved tours',
        'sign_in' => 'Sign in', 'sign_out' => 'Sign out', 'register' => 'Register',
    ],
    'tour' => [
        'from'          => 'From :price',
        'per_adult'     => 'per adult',
        'duration'      => ':days days / :nights nights',
        'reviews'       => ':count review|:count reviews',
        'included'      => "What's included",
        'excluded'      => 'Not included',
        'itinerary'     => 'Itinerary',
        'highlights'    => 'Highlights',
        'check_availability' => 'Check availability',
        'sold_out'      => 'Sold out',
        'no_departures' => 'No dates open — contact us for a private departure',
    ],
    'empty' => [
        'tours'    => 'No tours match those filters.',
        'bookings' => 'No bookings yet.',
        'generic'  => 'Nothing here yet.',
    ],
];
