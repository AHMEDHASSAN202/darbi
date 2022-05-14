<?php

namespace Modules\UserModule\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\UserModule\Entities\SavedPlace;
use Modules\UserModule\Entities\User;

class UserModuleDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        User::factory(100)->create();
        SavedPlace::factory(100)->create();

        // $this->call("OthersTableSeeder");
    }
}
