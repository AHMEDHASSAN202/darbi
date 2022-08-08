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
                    'value'         => 'automatic',
                    'image'         => [
                        'key'           => 'engine_type',
                        'value'         => 'https://i.ibb.co/q0bSNT5/liter.png',
                        'full_url'      => 'https://i.ibb.co/q0bSNT5/liter.png',
                        'name'          => 'Engine type'
                    ]
                ],
                'seats'   => [
                    'value'         => '4 seats',
                    'image'         => [
                        'key'           => 'seats',
                        'value'         => 'https://i.ibb.co/N1tNCy4/bedroom.png',
                        'full_url'      => 'https://i.ibb.co/N1tNCy4/bedroom.png',
                        'name'          => 'Seats'
                    ]
                ],
                'passengers'   => [
                    'value'         => '14 - 18 passengers',
                    'image'         => [
                        'key'           => 'passengers',
                        'value'         => 'https://i.ibb.co/nBjwmhP/passengers.png',
                        'full_url'      => 'https://i.ibb.co/nBjwmhP/passengers.png',
                        'name'          => 'Passengers'
                    ]
                ],
                'pilot'   => [
                    'value'         => 'pilot',
                    'image'         => [
                        'key'           => 'pilot',
                        'value'         => 'https://i.ibb.co/1vrxW5B/pilot.png',
                        'full_url'      => 'https://i.ibb.co/1vrxW5B/pilot.png',
                        'name'          => 'Pilot'
                    ]
                ]
            ],
            'is_active'      => true,
            'entity_type' => ['car', 'yacht'][mt_rand(0,1)],
        ];
    }
}

