<?php

namespace Modules\CatalogModule\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\CatalogModule\Entities\Branch;
use Modules\CatalogModule\Entities\Brand;
use Modules\CatalogModule\Entities\Extra;
use Modules\CatalogModule\Entities\Model;
use Modules\CatalogModule\Entities\Plugin;
use Modules\CatalogModule\Entities\Port;
use Modules\CatalogModule\Entities\Vendor;
use Modules\CatalogModule\Transformers\PortResource;
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

    private $type = 'yacht';

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $country = Country::all()->random(1)->first();
        $brand = Brand::where('entity_type', $this->type)->get()->random(1)->first();
        $model = Model::where('brand_id', new ObjectId($brand->_id))->get()->random(1)->first();
        $vendor = Vendor::where('type', $this->type)->get()->random(1)->first();
        $port = Port::with(['country', 'city'])->get()->random(1)->first();
        $arFaker = \Faker\Factory::create('ar_EG');
        $plugins = Plugin::where('entity_type', $this->type)->get()->pluck('id')->toArray();
        $extras = generateObjectIdOfArrayValues(Extra::whereIn('plugin_id', generateObjectIdOfArrayValues($plugins))->where('vendor_id', new ObjectId($vendor->_id))->get()->random(2)->pluck('_id')->toArray());

        return [
            'model_id'          => new ObjectId($model->_id),
            'brand_id'          => new ObjectId($brand->_id),
            'name'              => ['en' => $this->faker->company, 'ar' => $arFaker->company],
            'images'            => getRandomImages(getYatchTestImages(), mt_rand(1, 5)),
            'is_active'         => $this->faker->boolean,
            'is_available'      => $this->faker->boolean,
            'vendor_id'         => new ObjectId($vendor->_id),
            'port_id'           => new ObjectId($port->_id),
            'port'              => new PortResource($port),
            'branch_id'         => null,
            'branch'            => [],
            'state'             => ['free', 'reserved', 'pending'][mt_rand(0,2)],
            'extra_ids'         => generateObjectIdOfArrayValues($extras),
            'country_id'        => new ObjectId($country->_id),
            'require_activation'=> $this->faker->boolean,
            'price'             => $this->faker->randomFloat(2, 2000, 10000),
            'price_unit'        => 'hour',
            'built_date'        => 2017,
            'type'              => 'yacht'
        ];
    }
}

