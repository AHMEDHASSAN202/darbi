<?php

namespace Modules\CatalogModule\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\CatalogModule\Entities\Vendor;
use Modules\CommonModule\Entities\City;
use Modules\CommonModule\Entities\Region;
use MongoDB\BSON\ObjectId;

class BranchFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\CatalogModule\Entities\Branch::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $vendor = Vendor::all()->random(1)->first();
        $region = Region::all()->random(1)->first();
        $arFaker = \Faker\Factory::create('ar_EG');
        $cityId = City::all()->random(1)->first()->_id;

        return [
            'vendor_id'     => new ObjectId($vendor->_id),
            'name'          => ['ar' => $arFaker->company, 'en' => $this->faker->company],
            'cover_images'  => [
                $this->faker->imageUrl(800, 400, null, false, 'Cover'),
                $this->faker->imageUrl(800, 400, null, false, 'Cover'),
                $this->faker->imageUrl(800, 400, null, false, 'Cover'),
            ],
            'is_active'     => $this->faker->boolean,
            'is_open'       => $this->faker->boolean,
            'phone'         => [
                'phone'        => $this->faker->phoneNumber,
                'phone_code'   => $this->faker->countryCode
            ],
            'address'       => $this->faker->address,
            'lat'           => $this->faker->latitude,
            'lng'           => $this->faker->longitude,
            'city_id'       => new ObjectId($cityId),
            'require_activation' => $this->faker->boolean,
            'darbi_percentage'   => $this->faker->randomFloat(1, 1, 100),
            'region_id'    => new ObjectId($region->_id),
            'branch_times'  => [
                ['day_number' => 1, 'day_name' => "Monday", 'from' => "09:00", 'to' => "05:00"],
                ['day_number' => 2, 'day_name' => "Tuesday", 'from' => "10:00", 'to' => "04:00"],
                ['day_number' => 3, 'day_name' => "Wednesday", 'from' => "09:00", 'to' => "05:00"],
                ['day_number' => 4, 'day_name' => "Thursday", 'from' => "12:00", 'to' => "06:00"],
                ['day_number' => 6, 'day_name' => "Saturday", 'from' => "08:00", 'to' => "05:00"],
                ['day_number' => 6, 'day_name' => "Saturday", 'from' => "09:00", 'to' => "05:00"],
                ['day_number' => 7, 'day_name' => "Sunday", 'from' => "09:00", 'to' => "05:00"],
            ]
        ];
    }
}

