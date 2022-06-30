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
        $brandImages = getBrandTestImages();

        return [
            'name'      => ['ar' => $arFaker->company(), 'en' => $this->faker->company()],
            'logo'      => $brandImages[mt_rand(0, (count($brandImages) - 1))],
            'entity_type' => ['car', 'yacht'][mt_rand(0,1)],
            'is_active' => true
        ];
    }
}

