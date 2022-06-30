<?php

namespace Modules\CatalogModule\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\CatalogModule\Entities\Car;
use Modules\CatalogModule\Entities\Entity;
use Modules\CatalogModule\Entities\Plugin;

class EntityPluginSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $entities = Entity::get();

        foreach ($entities as $entity) {
            $plugins = Plugin::all()->random(3)->pluck('_id')->toArray();
            $entity->plugins()->attach($plugins);
        }
    }
}
