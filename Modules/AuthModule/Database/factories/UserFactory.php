<?php

namespace Modules\AuthModule\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\CommonModule\Entities\Country;
use MongoDB\BSON\ObjectId;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\AuthModule\Entities\User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
//        $arFaker = \Faker\Factory::create('ar_EG');
        $country = Country::all()->random(1)->first();

        return [
            'phone'         => str_replace('+', '', $this->faker->unique()->e164PhoneNumber()),
            'phone_code'    => $country->calling_code,
            'identity'      => [
                'frontside_image'   => $this->faker->imageUrl(500, 250, null, false, 'FrontSide'),
                'backside_image'    => $this->faker->imageUrl(500, 250, null, false, 'BackSide')
            ],
            'name'          => $this->faker->name(),
            'email'         => $this->faker->email,
            'is_active'     => $this->faker->boolean(),
//            'verification_code' => (int)$this->faker->unique()->numerify('#####'),
        ];
    }
}

