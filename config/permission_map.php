<?php

declare(strict_types=1);

/*
| Permission catalogue. The seeder reads this file, so adding a capability is a
| one-line change plus `php artisan db:seed --class=RolePermissionSeeder`.
*/

return [

    'permissions' => [
        'tour'        => ['view', 'create', 'update', 'delete', 'publish'],
        'booking'     => ['view', 'create', 'update', 'confirm', 'cancel', 'delete'],
        'payment'     => ['view', 'record', 'refund'],
        'customer'    => ['view', 'create', 'update', 'delete'],
        'user'        => ['view', 'create', 'update', 'delete'],
        'category'    => ['view', 'create', 'update', 'delete'],
        'destination' => ['view', 'create', 'update', 'delete'],
        'coupon'      => ['view', 'create', 'update', 'delete'],
        'review'      => ['view', 'approve', 'update', 'delete'],
        'cms'         => ['view', 'create', 'update', 'delete'],
        'report'      => ['view', 'export'],
        'setting'     => ['view', 'update'],
        'ticket'      => ['view', 'reply', 'close'],
    ],

    'roles' => [
        'super-admin' => '*',

        'admin' => [
            'tour.*', 'booking.*', 'payment.*', 'customer.*', 'category.*', 'destination.*',
            'coupon.*', 'review.*', 'cms.*', 'report.*', 'setting.view', 'ticket.*',
            'user.view', 'user.create', 'user.update',
        ],

        'manager' => [
            'tour.view', 'tour.create', 'tour.update', 'tour.publish',
            'booking.*', 'payment.view', 'payment.record',
            'customer.view', 'customer.update',
            'category.*', 'destination.*', 'coupon.*', 'review.*', 'cms.*',
            'report.view', 'report.export', 'ticket.*',
        ],

        'sales-executive' => [
            'tour.view', 'booking.view', 'booking.create', 'booking.update', 'booking.confirm',
            'payment.view', 'payment.record', 'customer.view', 'customer.create', 'customer.update',
            'coupon.view', 'ticket.view', 'ticket.reply', 'report.view',
        ],

        'tour-operator' => [
            'tour.view', 'tour.create', 'tour.update',
            'booking.view', 'booking.update',
            'category.view', 'destination.view', 'review.view',
        ],

        'customer' => [],
    ],
];
