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
        $avatars = getAvatarTestImages();

        $admins = [
           [
               'name'       => 'admin',
               'email'      => 'admin@godarbi.com',
               'password'   => Hash::make('Darbi@#123$'),
               'role_id'    => new ObjectId(Role::first()->id),
               'type'       => 'admin',
               'image'      => $avatars[mt_rand(0, (count($avatars) - 1))]
           ],
           [
               'name'       => 'mohamed',
               'email'      => 'mohamed@gmail.com',
               'password'   => Hash::make(123456),
               'role_id'    => new ObjectId(Role::first()->id),
               'type'       => 'admin',
               'image'      => $avatars[mt_rand(0, (count($avatars) - 1))]
           ],
            [
                'name'       => 'Car Vendor',
                'email'      => 'car-vendor@gmail.com',
                'password'   => Hash::make(123456),
                'role_id'    => new ObjectId(Role::where('guard', 'vendor_api')->first()->id),
                'vendor_id'  => new ObjectId(Vendor::where('type', 'car')->first()->id),
                'type'       => 'vendor',
                'image'      => $avatars[mt_rand(0, (count($avatars) - 1))]
            ],
            [
                'name'       => 'Yacht Vendor',
                'email'      => 'yacht-vendor@gmail.com',
                'password'   => Hash::make(123456),
                'role_id'    => new ObjectId(Role::where('guard', 'vendor_api')->first()->id),
                'vendor_id'  => new ObjectId(Vendor::where('type', 'yacht')->first()->id),
                'type'       => 'vendor',
                'image'      => $avatars[mt_rand(0, (count($avatars) - 1))]
            ],
            [
                'name'       => 'Villa Vendor',
                'email'      => 'villa-vendor@gmail.com',
                'password'   => Hash::make(123456),
                'role_id'    => new ObjectId(Role::where('guard', 'vendor_api')->first()->id),
                'vendor_id'  => new ObjectId(Vendor::where('type', 'villa')->first()->id),
                'type'       => 'vendor',
                'image'      => $avatars[mt_rand(0, (count($avatars) - 1))]
            ]
        ];

        foreach ($admins as $admin) {
            Admin::create($admin);
        }
    }
}
