<?php

namespace Modules\AdminModule\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\AdminModule\Entities\Role;

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
                'guard'       => 'admin_api',
                'permissions' => config('adminmodule.permissions')
            ],
            [
                'name'        => 'admin',
                'guard'       => 'admin_api',
                'permissions' => [
                    'manage-booking-cars', 'manage-vendors-cars', 'manage-addons', 'manage-locations', 'manage-cars-searches',
                    'manage-booking-yachts', 'manage-vendors-yachts', 'manage-ports',
                    'manage-users', 'manage-currencies', 'manage-settings'
                ]
            ],
            [
                'name'        => 'vendor manager',
                'guard'       => 'vendor_api',
                'permissions' => config('adminmodule.vendor_permissions')
            ],
            [
                'name'        => 'vendor support',
                'guard'       => 'vendor_api',
                'permissions' => [
                    'manage-booking-cars', 'manage-booking-yachts', 'manage-vendors-yachts', 'manage-ports'
                ]
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
