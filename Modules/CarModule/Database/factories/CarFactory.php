<?php

namespace Modules\CarModule\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\AddonsModule\Entities\Brand;
use Modules\AddonsModule\Entities\Model;
use Modules\AddonsModule\Entities\Plugin;
use Modules\CommonModule\Entities\Country;
use Modules\VendorModule\Entities\Branch;
use Modules\VendorModule\Entities\Vendor;

class CarFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\CarModule\Entities\Car::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $country = Country::all()->random(1)->first();
        $plugins = Plugin::all()->random(3)->pluck('_id')->toArray();
        $model = Model::all()->random(1)->first();
        $brand = Brand::all()->random(1)->first();
        $vendor = Vendor::all()->random(1)->first();
        $branches = $vendor->branches()->limit(3)->pluck('_id')->toArray();

        return [
            'model_id'          => $model->_id,
            'brand_id'          => $brand->_id,
            'images'            => [
                $this->faker->imageUrl(300, 300, 'car', false, 'Car'),
                $this->faker->imageUrl(300, 300, 'car', false, 'Car'),
                $this->faker->imageUrl(300, 300, 'car', false, 'Car')
            ],
            'is_active'         => $this->faker->boolean,
            'is_available'      => $this->faker->boolean,
            'vendor_id'         => $vendor->_id,
            'branch_ids'        => $branches,
            'state'             => ['free', 'reserved', 'pending'][mt_rand(0,2)],
            'plugins_ids'       => $plugins,
            'country_id'        => $country->_id,
            'require_activation'=> $this->faker->boolean,
            'type'              => 'car'
        ];
    }
}

