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
                    'key'       => 'engine_type',
                    'value'     => '4.0-liter V-8',
                    'image'     => 'https://i.ibb.co/q0bSNT5/liter.png',
                ],
                'seats'   => [
                    'key'       => 'seats',
                    'value'     => '4 Seats',
                    'image'     => 'https://i.ibb.co/stLWkxg/seats.png',
                ],
                'passengers'   => [
                    'key'       => 'passengers',
                    'value'     => '4 passengers',
                    'image'     => 'https://i.ibb.co/nBjwmhP/passengers.png',
                ],
                'pilot'   => [
                    'key'       => 'captain',
                    'value'     => 'Captain',
                    'image'     => 'https://i.ibb.co/1vrxW5B/pilot.png',
                ],
                'cabins'   => [
                    'key'       => 'cabins',
                    'value'     => 'Cabins',
                    'image'     => 'https://i.ibb.co/DpW68yv/cabins.png',
                ]
            ],
            'is_active'      => true,
            'entity_type' => ['car', 'yacht'][mt_rand(0,1)],
        ];
    }
}

