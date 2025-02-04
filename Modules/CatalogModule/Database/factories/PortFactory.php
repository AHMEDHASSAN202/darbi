<?php

namespace Modules\CatalogModule\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\CommonModule\Entities\City;
use Modules\CommonModule\Entities\Country;
use MongoDB\BSON\ObjectId;

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
        $city = City::where('country_id', new ObjectId($country->id))->get()->random(1)->first();

        return [
            'name'      => ['ar' => $arFaker->company(), 'en' => $this->faker->company()],
            'country_id'=> new ObjectId($country->_id),
            'city_id'   => new ObjectId($city->_id),
            'country'   => $country->name,
            'city'      => $city->name,
            'fully_addressed' => $this->faker->streetAddress,
            'lat'       => $this->faker->latitude,
            'lng'       => $this->faker->longitude,
            'is_active' => $this->faker->boolean
        ];
    }
}

