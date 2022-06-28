<?php

return [
    'name' => 'AuthModule',
    'permissions'   => [
        'admin_api'     => [
            'manage-booking-cars', 'manage-vendors-cars', 'manage-addons', 'manage-locations', 'manage-cars-searches',
            'manage-booking-yachts', 'manage-vendors-yachts', 'manage-ports',
            'manage-users', 'manage-currencies', 'manage-settings', 'manage-admins', 'manage-roles', 'manage-logs',
            'manage-file-manager'
        ],
        'vendor_api'     => [
            'manage-booking-cars', 'manage-addons', 'manage-locations', 'manage-cars-searches',
            'manage-booking-yachts', 'manage-vendors-yachts', 'manage-ports'
        ]
    ],
    'used_otp_provider' => true,
    'otp_messages'  => [
        'Your darbi verification code is: %s',
        'Darbi OTP: %s . هذا الكود سري يرجى عدم مشاركته مع أحد',
        'الكود المتغير الخاص بك في داربي هو: %s',
    ]
];
