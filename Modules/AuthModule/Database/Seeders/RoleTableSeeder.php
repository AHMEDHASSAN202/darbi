<?php

namespace Modules\AuthModule\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\AuthModule\Entities\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $roles = [
            [
                'name'        => 'super admin',
                'key'         => 'super_admin',
                'guard'       => 'admin_api',
                'permissions' => config('authmodule.permissions.admin_api')
            ],
            [
                'name'        => 'admin',
                'guard'       => 'admin_api',
                'permissions' => [
                    'manage-booking-entity', 'manage-extras', 'manage-branches', 'manage-orders', 'manage-payments',
                    'manage-vendors', 'manage-ports', 'manage-plugins', 'manage-reports', 'manage-queue-approval', 'manage-brands', 'manage-models',
                    'manage-users'
                ]
            ],
            [
                'name'        => 'vendor manager',
                'key'         => 'vendor_manager',
                'guard'       => 'vendor_api',
                'permissions' => config('authmodule.permissions.vendor_api')
            ],
            [
                'name'        => 'vendor support',
                'guard'       => 'vendor_api',
                'permissions' => [
                    'manage-settings', 'manage-orders', 'accept-booking', 'manage-payments'
                ]
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
