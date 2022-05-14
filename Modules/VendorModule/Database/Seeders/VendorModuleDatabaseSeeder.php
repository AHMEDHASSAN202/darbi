<?php

namespace Modules\VendorModule\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\VendorModule\Entities\Branch;
use Modules\VendorModule\Entities\Subscription;
use Modules\VendorModule\Entities\Vendor;

class VendorModuleDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        Subscription::factory(5)->create();
        Vendor::factory(100)->create();
        Branch::factory(200)->create();
    }
}
