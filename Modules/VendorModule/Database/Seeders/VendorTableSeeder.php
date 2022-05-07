<?php

namespace Modules\VendorModule\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Modules\AdminModule\Entities\Role;
use Modules\VendorModule\Entities\Vendor;

class VendorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $vendors = [
           [
               'name'       => 'vendor',
               'email'      => 'vendor@vendor.com',
               'password'   => Hash::make(123456),
               'role_id'    => Role::where('guard', 'vendor_api')->first()->id,
               'phone'      => null
           ], [
                'name'       => 'vendor support',
                'email'      => 'support@vendor.com',
                'password'   => Hash::make(123456),
                'role_id'    => Role::where('guard', 'vendor_api')->latest()->first()->id,
                'phone'      => null
            ],
        ];

        foreach ($vendors as $vendor) {
            Vendor::create($vendor);
        }
    }
}
