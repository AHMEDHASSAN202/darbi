<?php

namespace Modules\CatalogModule\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\CatalogModule\Entities\Branch;
use Modules\CatalogModule\Entities\Brand;
use Modules\CatalogModule\Entities\Car;
use Modules\CatalogModule\Entities\Plugin;
use Modules\CatalogModule\Entities\Port;
use Modules\CatalogModule\Entities\Subscription;
use Modules\CatalogModule\Entities\Vendor;
use Modules\CatalogModule\Entities\Yacht;

class CatalogModuleDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        Brand::factory(100)->create();
        \Modules\CatalogModule\Entities\Model::factory(100)->create();
        Plugin::factory(300)->create();
        Subscription::factory(5)->create();
        Vendor::factory(100)->create();
        Branch::factory(200)->create();
        Car::factory(500)->create();
        Port::factory(100)->create();
        Yacht::factory(500)->create();
        $this->call(EntityPluginSeederTableSeeder::class);
    }
}
