<?php

namespace Modules\AdminModule\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Modules\AdminModule\Entities\Admin;
use Modules\AdminModule\Entities\Role;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $admins = [
           [
               'name'       => 'ahemd',
               'email'      => 'ahemd@gmail.com',
               'password'   => Hash::make(123456),
               'role_id'    => Role::first()->id
           ]
        ];

        foreach ($admins as $admin) {
            Admin::create($admin);
        }
    }
}
