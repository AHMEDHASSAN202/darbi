<?php

namespace Modules\AuthModule\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\AuthModule\Entities\Admin;
use Modules\AuthModule\Entities\SavedPlace;
use Modules\AuthModule\Entities\User;
use Modules\CatalogModule\Entities\Vendor;

class AuthModuleDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

//        Vendor::factory()->count(5)->create();
        $this->call(RoleTableSeeder::class);
        $this->call(AdminTableSeeder::class);
//        User::factory()->count(50)->create();
//        SavedPlace::factory()->count(50)->create();
    }
}
