<?php

namespace Modules\CommonModule\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\CommonModule\Entities\CarType;

class CarTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $types = ['SUV', 'Sedan', 'Coupe', 'Sport', 'Compact', 'Hatchback', 'EV'];

        foreach ($types as $type) {
            CarType::create(['name' => $type]);
        }
    }
}
