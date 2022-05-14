<?php

namespace Modules\AddonsModule\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\AddonsModule\Entities\Brand;
use Modules\AddonsModule\Entities\Model;
use Modules\AddonsModule\Entities\Plugin;

class AddonsModuleDatabaseSeeder extends Seeder
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
        Model::factory(100)->create();
        Plugin::factory(100)->create();

        // $this->call("OthersTableSeeder");
    }
}
