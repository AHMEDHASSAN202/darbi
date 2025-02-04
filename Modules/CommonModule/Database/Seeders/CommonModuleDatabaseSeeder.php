<?php

namespace Modules\CommonModule\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\CommonModule\Entities\CarType;
use Modules\CommonModule\Entities\Region;
use Modules\CommonModule\Entities\StartUpImage;

class CommonModuleDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(CountryTableSeeder::class);
        $this->call(CityTableSeeder::class);
        $this->call(SettingTableSeeder::class);
        $this->call(CarTypeTableSeeder::class);
        StartUpImage::factory()->count(5)->create();
    }
}
