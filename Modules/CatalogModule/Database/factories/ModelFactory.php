<?php

namespace Modules\CatalogModule\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\CatalogModule\Entities\Brand;
use MongoDB\BSON\ObjectId;

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
            'brand_id'      => new ObjectId($brand->_id),
            'name'          => ['ar' => $arFaker->companySuffix(), 'en' => $this->faker->companySuffix()],
            'images'        => [
                $this->faker->imageUrl(300, 300, null, false, 'Model'),
                $this->faker->imageUrl(300, 300, null, false, 'Model'),
                $this->faker->imageUrl(300, 300, null, false, 'Model')
            ],
            'specs'         => [
                'engine_type'   => [
                    'name'          => ['ar' => 'automatic', 'en' => 'automatic'],
                    'image'         => 'https://i.ibb.co/q0bSNT5/liter.png',
                    'order_weight'  => 2,
                    'value'         => '',
                    'group_details' => ['ar' => 'Details', 'en' => 'Details', 'key' => 'general']
                ],
                'seats'   => [
                    'name'          => ['ar' => 'seats', 'en' => 'seats'],
                    'image'         => 'https://i.ibb.co/N1tNCy4/bedroom.png',
                    'order_weight'  => 3,
                    'value'         => 3,
                    'group_details' => ['ar' => 'Details', 'en' => 'Details', 'key' => 'general']
                ],
                'passengers'   => [
                    'name'          => ['ar' => 'passengers', 'en' => 'passengers'],
                    'image'         => 'https://i.ibb.co/nBjwmhP/passengers.png',
                    'order_weight'  => 1,
                    'value'         => [
                        'minimum'           => 4,
                        'maximum'           => 10
                    ],
                    'group_details' => ['ar' => 'Details', 'en' => 'Details', 'key' => 'general']
                ],
            ],
            'is_active'      => true
        ];
    }
}

