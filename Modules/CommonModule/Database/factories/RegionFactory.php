<?php

namespace Modules\CommonModule\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\CommonModule\Entities\City;

class RegionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\CommonModule\Entities\Region::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $arFaker = \Faker\Factory::create('ar_EG');
        $city = City::with('country')->get()->random(1)->first();

        return [
            'name'      => ['ar' => $arFaker->streetAddress(), 'en' => $this->faker->streetAddress()],
            'city_id'   => $city->_id,
            'country_id'=> $city->country->_id,
            'location'  => [
                'type'          => 'Polygon',
                'coordinates'   => [
                    [34.783342, 32.075312],
                    [34.782876, 32.075323],
                    [34.782862, 32.074953],
                    [34.783407, 32.07494],
                    [34.783342, 32.075312]
                ]
            ],
            'is_active' => $this->faker->boolean
        ];
    }
}

