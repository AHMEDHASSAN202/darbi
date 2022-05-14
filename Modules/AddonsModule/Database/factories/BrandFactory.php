<?php

namespace Modules\AddonsModule\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BrandFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\AddonsModule\Entities\Brand::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $arFaker = \Faker\Factory::create('ar_EG');

        return [
            'name'  => ['ar' => $arFaker->company(), 'en' => $this->faker->company()],
            'logo'  => $this->faker->imageUrl(150, 150, 'logo', false, 'Logo')
        ];
    }
}

