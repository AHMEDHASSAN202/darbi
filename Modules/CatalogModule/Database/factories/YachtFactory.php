<?php

namespace Modules\CatalogModule\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\CatalogModule\Entities\Brand;
use Modules\CatalogModule\Entities\Model;
use Modules\CatalogModule\Entities\Plugin;
use Modules\CatalogModule\Entities\Port;
use Modules\CatalogModule\Entities\Vendor;
use Modules\CommonModule\Entities\City;
use Modules\CommonModule\Entities\Country;
use MongoDB\BSON\ObjectId;

class YachtFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\CatalogModule\Entities\Yacht::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $country = Country::all()->random(1)->first();
        $city = City::where('country_id', new ObjectId($country->_id))->get()->random(1)->first();
        $plugins = Plugin::all()->random(2)->pluck('_id')->toArray();
        $model = Model::all()->random(1)->first();
        $brand = Brand::all()->random(1)->first();
        $vendor = Vendor::all()->random(1)->first();
        $branches = $vendor->branches()->limit(3)->pluck('_id')->toArray();
        $port = Port::all()->random(1)->first();
        $arFaker = \Faker\Factory::create('ar_EG');

        return [
            'model_id'          => new ObjectId($model->_id),
            'brand_id'          => new ObjectId($brand->_id),
            'name'              => ['en' => $this->faker->company, 'ar' => $arFaker->company],
            'images'            => getRandomImages(getYatchTestImages(), mt_rand(1, 5)),
            'is_active'         => $this->faker->boolean,
            'is_available'      => $this->faker->boolean,
            'vendor_id'         => new ObjectId($vendor->_id),
            'port_id'           => new ObjectId($port->_id),
            'branch_ids'        => $branches,
            'state'             => ['free', 'reserved', 'pending'][mt_rand(0,2)],
            'plugin_ids'        => $plugins,
            'country_id'        => new ObjectId($country->_id),
            'city_id'           => new ObjectId($city->_id),
            'require_activation'=> $this->faker->boolean,
            'price'             => $this->faker->randomFloat(2, 2000, 10000),
            'price_unit'        => 'hour',
            'built_date'        => '2017',
            'type'              => 'yacht'
        ];
    }
}

