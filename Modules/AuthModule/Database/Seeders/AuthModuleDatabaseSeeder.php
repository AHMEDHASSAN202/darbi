<?php

namespace Modules\AuthModule\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\AuthModule\Entities\Admin;
use Modules\AuthModule\Entities\SavedPlace;
use Modules\AuthModule\Entities\User;

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


        $this->call(RoleTableSeeder::class);
        $this->call(AdminTableSeeder::class);
        Admin::factory()->count(10)->create();
        User::factory()->count(50)->create();
        SavedPlace::factory()->count(100)->create();
    }
}
