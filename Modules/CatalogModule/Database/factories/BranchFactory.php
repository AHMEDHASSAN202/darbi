<?php

namespace Modules\CatalogModule\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\CatalogModule\Entities\Vendor;
use Modules\CatalogModule\Enums\EntityType;
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
        $vendor = Vendor::where('type', EntityType::CAR)->get()->random(1)->first();
        try {
            $regions = Region::where('vendor_id', new ObjectId($vendor->id))->get()->random(2)->pluck('_id')->toArray();
        }catch (\Exception $exception) {
            $region = Region::where('vendor_id', new ObjectId($vendor->id))->first();
            $regions = [];
            if ($region) {
                $regions = [(string)$region->_id];
            }
        }
        $arFaker = \Faker\Factory::create('ar_EG');
        $city = City::all()->random(1)->first();

        return [
            'vendor_id'     => new ObjectId($vendor->_id),
            'name'          => ['ar' => $arFaker->company, 'en' => $this->faker->company],
            'cover_images'  => [
                $this->faker->imageUrl(800, 400, null, false, 'Cover'),
                $this->faker->imageUrl(800, 400, null, false, 'Cover'),
                $this->faker->imageUrl(800, 400, null, false, 'Cover'),
            ],
            'is_active'     => true,
            'phone'         => [
                'phone'        => $this->faker->numberBetween(1111111111, 9999999999),
                'phone_code'   => 966
            ],
            'address'       => $this->faker->address,
            'city_id'       => new ObjectId($city->_id),
            'require_activation' => $this->faker->boolean,
            'regions_ids'    => generateObjectIdOfArrayValues($regions),
            'branch_times'  => [
                ['day_number' => 1, 'day_name' => "Monday", 'from' => "09:00", 'to' => "05:00"],
                ['day_number' => 2, 'day_name' => "Tuesday", 'from' => "10:00", 'to' => "04:00"],
                ['day_number' => 3, 'day_name' => "Wednesday", 'from' => "09:00", 'to' => "05:00"],
                ['day_number' => 4, 'day_name' => "Thursday", 'from' => "12:00", 'to' => "06:00"],
                ['day_number' => 6, 'day_name' => "Saturday", 'from' => "08:00", 'to' => "05:00"],
                ['day_number' => 6, 'day_name' => "Saturday", 'from' => "09:00", 'to' => "05:00"],
                ['day_number' => 7, 'day_name' => "Sunday", 'from' => "09:00", 'to' => "05:00"],
            ],
            'lat'                   => $city->lat,
            'lng'                   => $city->lng
        ];
    }
}

