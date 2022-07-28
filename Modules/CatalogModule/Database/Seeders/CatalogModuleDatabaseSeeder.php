<?php

namespace Modules\CatalogModule\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\CatalogModule\Entities\Branch;
use Modules\CatalogModule\Entities\Brand;
use Modules\CatalogModule\Entities\Car;
use Modules\CatalogModule\Entities\Extra;
use Modules\CatalogModule\Entities\Plugin;
use Modules\CatalogModule\Entities\Port;
use Modules\CatalogModule\Entities\Subscription;
use Modules\CatalogModule\Entities\Vendor;
use Modules\CatalogModule\Entities\Yacht;
use Modules\CommonModule\Entities\Region;

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

//        Brand::factory(22)->create();
//        \Modules\CatalogModule\Entities\Model::factory(150)->create();
//        Plugin::factory(100)->create();
//        Vendor::factory(3)->create();
//        Region::factory()->count(150)->create();
//        $this->call(RegionsTableSeeder::class);
//        Extra::factory(400)->create();
//        Subscription::factory(5)->create();
//        Branch::factory(50)->create();
//        Car::factory(80)->create();
//        Port::factory(20)->create();
//        Yacht::factory(80)->create();
//        $this->call(EntityPluginSeederTableSeeder::class);
    }
}
