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
            ]
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
