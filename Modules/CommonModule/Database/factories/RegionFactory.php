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
                    [
                        [32.2514649, 30.8006084],
                        [31.4494630, 30.2609135],
                        [30.2189942, 30.5548038],
                        [29.8948975, 31.1493256],
                        [30.9770508, 31.5670350],
                        [32.1525880, 31.2809398],
                        [32.2514649, 30.8006084],
                    ]
                ]
            ],
            'is_active' => $this->faker->boolean
        ];
    }
}

