<?php

return [
    'name'          => 'AdminModule',
    'permissions'   => [
        'manage-booking-cars', 'manage-vendors-cars', 'manage-addons', 'manage-locations', 'manage-cars-searches',
        'manage-booking-yachts', 'manage-vendors-yachts', 'manage-ports',
        'manage-users', 'manage-currencies', 'manage-settings', 'manage-admins', 'manage-roles', 'manage-logs',
        'manage-file-manager'
    ],
    'vendor_permissions'   => [
        'manage-booking-cars', 'manage-addons', 'manage-locations', 'manage-cars-searches',
        'manage-booking-yachts', 'manage-vendors-yachts', 'manage-ports'
    ]
];
