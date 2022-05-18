<?php

namespace Modules\CatalogModule\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\CommonModule\Entities\Country;

class PortFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\CatalogModule\Entities\Port::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $arFaker = \Faker\Factory::create('ar_EG');
        $country = Country::all()->random(1)->first();

        return [
            'name'      => ['ar' => $arFaker->company(), 'en' => $this->faker->company()],
            'country_id'=> $country->_id,
            'lat'       => $this->faker->latitude,
            'lng'       => $this->faker->longitude,
            'is_active' => $this->faker->boolean
        ];
    }
}

