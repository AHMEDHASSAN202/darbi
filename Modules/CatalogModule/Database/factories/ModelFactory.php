<?php

namespace Modules\CatalogModule\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\CatalogModule\Entities\Brand;

class ModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\CatalogModule\Entities\Model::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $arFaker = \Faker\Factory::create('ar_EG');
        $brand = Brand::all()->random(1)->first();

        return [
            'brand_id'      => $brand->_id,
            'name'          => ['ar' => $arFaker->companySuffix(), 'en' => $this->faker->companySuffix()],
            'images'        => [
                $this->faker->imageUrl(300, 300, null, false, 'Model'),
                $this->faker->imageUrl(300, 300, null, false, 'Model'),
                $this->faker->imageUrl(300, 300, null, false, 'Model')
            ],
            'specs'         => [
                'engine_type'   => [
                    'name'          => ['ar' => 'automatic', 'en' => 'automatic'],
                    'image'         => $this->faker->imageUrl(100, 100, null, false, 'automatic'),
                    'order_weight'  => 1,
                    'group_details' => ['ar' => $arFaker->title(), 'en' => $this->faker->title(), 'key' => 'general']
                ],
                'seats'   => [
                    'name'          => ['ar' => 'seats', 'en' => 'seats'],
                    'image'         => $this->faker->imageUrl(100, 100, null, false, 'seats'),
                    'order_weight'  => 2,
                    'group_details' => ['ar' => $arFaker->title(), 'en' => $this->faker->title(), 'key' => 'general']
                ],
            ],
            'is_active'      => true
        ];
    }
}

