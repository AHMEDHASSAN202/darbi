<?php

namespace Modules\CatalogModule\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BrandFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\CatalogModule\Entities\Brand::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $arFaker = \Faker\Factory::create('ar_EG');

        return [
            'name'      => ['ar' => $arFaker->company(), 'en' => $this->faker->company()],
            'logo'      => $this->faker->imageUrl(150, 150, 'logo', false, 'Logo'),
            'entity_type' => ['car', 'yacht'][mt_rand(0,1)],
            'is_active' => true//$this->faker->boolean
        ];
    }
}

