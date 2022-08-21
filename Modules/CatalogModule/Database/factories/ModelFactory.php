<?php

namespace Modules\CatalogModule\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\CatalogModule\Entities\Attribute;
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
        $specs = generateObjectIdOfArrayValues(Attribute::whereIn('key', ['engine_type', 'seats', 'passengers', 'captain', 'cabins'])->get()->map(function ($attr) { return ['id' => $attr->id, 'key' => $attr->key, 'value' => $attr->value, 'image' => $attr->image]; })->toArray());

        return [
            'brand_id'      => new ObjectId($brand->_id),
            'name'          => ['ar' => $arFaker->companySuffix(), 'en' => $this->faker->companySuffix()],
            'images'        => [
                $this->faker->imageUrl(300, 300, null, false, 'Model'),
                $this->faker->imageUrl(300, 300, null, false, 'Model'),
                $this->faker->imageUrl(300, 300, null, false, 'Model')
            ],
            'specs'         => $specs,
            'is_active'      => true,
            'entity_type' => ['car', 'yacht'][mt_rand(0,1)],
        ];
    }
}

