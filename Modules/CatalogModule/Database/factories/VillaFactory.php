<?php

namespace Modules\CatalogModule\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\CatalogModule\Entities\Attribute;
use Modules\CatalogModule\Entities\Branch;
use Modules\CatalogModule\Entities\Brand;
use Modules\CatalogModule\Entities\Extra;
use Modules\CatalogModule\Entities\Model;
use Modules\CatalogModule\Entities\Plugin;
use Modules\CatalogModule\Entities\Port;
use Modules\CatalogModule\Entities\Vendor;
use Modules\CatalogModule\Enums\EntityStatus;
use Modules\CatalogModule\Enums\EntityType;
use Modules\CatalogModule\Transformers\PortResource;
use Modules\CommonModule\Entities\City;
use Modules\CommonModule\Entities\Country;
use MongoDB\BSON\ObjectId;

class VillaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\CatalogModule\Entities\Villa::class;

    private $type = EntityType::VILLA;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $country = Country::all()->random(1)->first();
        $vendor = Vendor::where('type', $this->type)->get()->random(1)->first();
        $arFaker = \Faker\Factory::create('ar_EG');
        $plugins = Plugin::where('entity_type', $this->type)->get()->pluck('id')->toArray();
        try {
            $extras = generateObjectIdOfArrayValues(Extra::whereIn('plugin_id', generateObjectIdOfArrayValues($plugins))->where('vendor_id', new ObjectId($vendor->_id))->get()->random(2)->pluck('_id')->toArray());
        }catch (\Exception $exception) {
            $extras = [];
        }
        $city = City::all()->where('country_id', new ObjectId($country->id))->random(1)->first();
        $attributes = generateObjectIdOfArrayValues(Attribute::whereIn('key', ['length', 'restrooms', 'guests', 'pool', 'beds'])->get()->map(function ($attr) { return ['id' => $attr->id, 'key' => $attr->key, 'value' => $attr->value, 'image' => $attr->image]; })->toArray());;

        return [
            'name'              => ['en' => $this->faker->company, 'ar' => $arFaker->company],
            'images'            => getRandomImages(getVillaTestImages(), mt_rand(1, 5)),
            'is_active'         => $this->faker->boolean,
            'is_available'      => $this->faker->boolean,
            'vendor_id'         => new ObjectId($vendor->_id),
            'state'             => array_values(EntityStatus::getTypes())[mt_rand(0,2)],
            'extra_ids'         => generateObjectIdOfArrayValues($extras),
            'country_id'        => new ObjectId($country->_id),
            'require_activation'=> $this->faker->boolean,
            'price'             => $this->faker->randomFloat(2, 2000, 10000),
            'price_unit'        => 'hour',
            'built_date'        => 2017,
            'location'          => [
                'lat'               => $this->faker->latitude,
                'lng'               => $this->faker->longitude,
                'fully_addressed'   => $this->faker->address,
                'city'              => $this->faker->city,
                'country'           => $this->faker->country,
                'state'             => $this->faker->streetAddress,
                'name'              => $this->faker->streetAddress,
                'region_id'         => null
            ],
            'city_id'           => new ObjectId($city->id), //when entity is villa
            'attributes'        => $attributes
        ];
    }
}

