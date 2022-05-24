<?php

namespace Modules\AuthModule\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\AuthModule\Entities\Admin;
use Modules\AuthModule\Entities\Role;
use MongoDB\BSON\ObjectId;

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
               'role_id'    => new ObjectId(Role::first()->id)
           ]
        ];

        foreach ($admins as $admin) {
            Admin::create($admin);
        }
    }
}
