<?php

namespace Modules\UserModule\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\CommonModule\Entities\City;
use Modules\CommonModule\Entities\Region;
use Modules\UserModule\Entities\User;

class SavedPlaceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\UserModule\Entities\SavedPlace::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'       => User::all()->random(1)->first()->_id,
            'lat'           => $this->faker->latitude(),
            'lng'           => $this->faker->longitude(),
            'city'          => $this->faker->city(),
            'country'       => $this->faker->country(),
            'region_id'     => Region::all()->random(1)->first()->_id
        ];
    }
}

