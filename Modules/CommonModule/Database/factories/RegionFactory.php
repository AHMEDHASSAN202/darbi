<?php

namespace Modules\CommonModule\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\CommonModule\Entities\City;
use MongoDB\BSON\ObjectId;

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
            'city_id'   => new ObjectId($city->_id),
            'country_id'=> new ObjectId($city->country->_id),
            'location'  => [
                'type'          => 'Polygon',
                'coordinates'   => [
                    [
                        [48.6210948, 28.4982974],
                        [41.7216808, 31.1678264],
                        [37.4589854, 31.4683232],
                        [36.4482433, 29.3449541],
                        [34.6904308, 28.0723931],
                        [37.3710948, 23.8437952],
                        [39.4365245, 20.2171151],
                        [42.0732433, 16.5039081],
                        [51.3017589, 18.7664568],
                        [55.3007823, 20.5468411],
                        [57.1025401, 24.2453283],
                        [56.6630870, 26.9022701],
                        [48.6210948, 28.4209871],
                        [48.6210948, 28.4982974],
                    ]
                ]
            ],
            'is_active' => true
        ];
    }
}

