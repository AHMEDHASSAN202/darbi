<?php

namespace Modules\CatalogModule\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\CatalogModule\Entities\Brand;
use Modules\CatalogModule\Entities\Extra;
use Modules\CatalogModule\Entities\Model;
use Modules\CatalogModule\Entities\Vendor;
use Modules\CommonModule\Entities\City;
use Modules\CommonModule\Entities\Country;
use MongoDB\BSON\ObjectId;

class CarFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\CatalogModule\Entities\Car::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $arFaker = \Faker\Factory::create('ar_EG');
        $country = Country::all()->random(1)->first();
        $city = City::where('country_id', new ObjectId($country->_id))->get()->random(1)->first();
        $model = Model::where('entity_type', 'car')->get()->random(1)->first();
        $brand = Brand::where('entity_type', 'car')->get()->random(1)->first();
        $vendor = Vendor::all()->random(1)->first();
        $branches = $vendor->branches()->limit(3)->pluck('_id')->toArray();

        return [
            'name'              => ['en' => $this->faker->company, 'ar' => $arFaker->company],
            'model_id'          => new ObjectId($model->_id),
            'brand_id'          => new ObjectId($brand->_id),
            'images'            => getRandomImages(getCarTestImages(), mt_rand(1, 5)),
            'is_active'         => true,//$this->faker->boolean,
            'is_available'      => $this->faker->boolean,
            'vendor_id'         => new ObjectId($vendor->_id),
            'branch_ids'        => $branches,
            'state'             => 'free',//['free', 'reserved', 'pending'][mt_rand(0,2)],
            'extra_ids'         => generateObjectIdOfArrayValues(Extra::all()->random(2)->pluck('_id')->toArray()),
            'country_id'        => new ObjectId($country->_id),
            'city_id'           => new ObjectId($city->_id),
            'require_activation'=> $this->faker->boolean,
            'price'             => $this->faker->randomFloat(2, 2000, 10000),
            'price_unit'        => 'day', //day or hour
            'type'              => 'car',
            'unavailable_date'  => $this->faker->boolean ? ['from' => new \MongoDB\BSON\UTCDateTime(now()->subDay()->toDateTime()), 'to' => new \MongoDB\BSON\UTCDateTime(now()->addMonth()->toDateTime())] : null
        ];
    }
}

