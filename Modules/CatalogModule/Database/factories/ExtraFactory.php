<?php

namespace Modules\CatalogModule\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\CatalogModule\Entities\Plugin;
use MongoDB\BSON\ObjectId;

class ExtraFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\CatalogModule\Entities\Extra::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'plugin_id'      => new ObjectId(Plugin::all()->random(1)->first()->_id),
            'price'          => $this->faker->randomFloat(2, 200, 1000),
        ];
    }
}

