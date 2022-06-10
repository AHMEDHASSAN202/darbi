<?php

namespace Modules\AuthModule\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\AuthModule\Entities\Admin;
use Modules\AuthModule\Entities\Role;
use Modules\CatalogModule\Entities\Vendor;
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
           ],
            [
                'name'       => 'vendor name',
                'email'      => 'vendor@gmail.com',
                'password'   => Hash::make(123456),
                'role_id'    => new ObjectId(Role::where('guard', 'vendor_api')->first()->id),
                'vendor_id'  => new ObjectId(Vendor::first()->id)
            ]
        ];

        foreach ($admins as $admin) {
            Admin::create($admin);
        }
    }
}
