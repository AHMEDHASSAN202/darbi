<?php

namespace Modules\CatalogModule\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PluginFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\CatalogModule\Entities\Plugin::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $arFaker = \Faker\Factory::create('ar_EG');

        return [
            'name'          => ['ar' => $arFaker->text(50), 'en' => $this->faker->text(50)],
            'price'         => $this->faker->numberBetween(1500, 6000),
            'price_unit'    => ['day', 'hour'][mt_rand(0,1)],
            'is_active'     => $this->faker->boolean(),
        ];
    }
}

