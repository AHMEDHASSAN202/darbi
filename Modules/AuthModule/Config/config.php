<?php

return [
    'name' => 'AuthModule',
    'permissions'   => [
        'admin_api'     => [
            'manage-booking-entity', 'manage-extras', 'manage-branches', 'manage-orders', 'manage-payments',
            'manage-vendors', 'manage-ports', 'manage-plugins', 'manage-reports', 'manage-queue-approval', 'manage-brands', 'manage-models',
            'manage-users', 'manage-settings', 'manage-admins', 'manage-roles', 'manage-logs', 'manage-file-manager'
        ],
        'vendor_api'     => [
            'manage-booking-entity', 'manage-extras', 'manage-branches', 'manage-settings', 'manage-orders', 'accept-booking', 'manage-payments'
        ]
    ],
    'default_vendor_role' => 'vendor_manager',
    'system_roles' => ['super_admin', 'vendor_manager'],
    'used_otp_provider' => true,
    'otp_messages'  => [
        'Your darbi verification code is: %s',
        'Darbi OTP: %s . هذا الكود سري يرجى عدم مشاركته مع أحد',
        'الكود المتغير الخاص بك في داربي هو: %s',
    ],
    'jwt_version'   => 1
];
