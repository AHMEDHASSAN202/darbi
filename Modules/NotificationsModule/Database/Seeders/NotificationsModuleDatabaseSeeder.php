<?php

namespace Modules\NotificationsModule\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\NotificationsModule\Entities\NotificationsCenter;

class NotificationsModuleDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

//        NotificationsCenter::factory()->count(200)->create();
    }
}
