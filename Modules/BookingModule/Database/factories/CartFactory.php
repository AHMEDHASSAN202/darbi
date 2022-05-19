<?php

namespace Modules\BookingModule\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\CatalogModule\Entities\Car;
use Modules\CatalogModule\Entities\Vendor;
use Modules\CommonModule\Entities\Country;
use Modules\CommonModule\Entities\Region;

class CartFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\BookingModule\Entities\Cart::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $vendor = Vendor::all()->random(1)->first();
        $ent = Car::withoutGlobalScope('car')->get()->random(1)->first();
        $branch = $vendor->branches()->first();
        $country = Country::all()->random(1)->first();
        $region = Region::active()->get()->random(1)->first();
        $arFaker = \Faker\Factory::create('ar_EG');

        return [
            'vendor_id'             => $vendor->_id,
            'branch_id'             => $branch?->_id,
            'country_id'            => $country->_id,
            'entity_id'             => $ent->_id,
            'start_booking_at'      => now()->subDay()->timestamp,
            'end_booking_at'        => now()->addMonth()->timestamp,
            'pickup_location_address'   => [
                'lat'               => $this->faker->latitude,
                'lng'               => $this->faker->longitude,
                'fully_addressed'   => $this->faker->address,
                'city'              => $this->faker->city,
                'country'           => $this->faker->country,
                'state'             => $this->faker->streetAddress,
                'region_id'         => $region->_id
            ],
            'items_details'         => [
                [
                    'name'          => ['ar' => $arFaker->text(10), 'en' => $this->faker->text(10)],
                    'price_per_day' => $this->faker->randomFloat(100, 500),
                    'plugins'       => [
                        [
                            'name'   => ['ar' => $arFaker->text(8), 'en' => $this->faker->text(10)],
                            'price_per_day' => $this->faker->randomFloat(100,500)
                        ]
                    ]
                ]
            ],
            'price_summary'          => [
                'total_discount'    => 22.2,
                'discount_value'    => 22,
                'total_price_before_discount_before_vat' => 23.3,
                'total_price_after_discount_before_vat' => 23.3,
                'total_vat'         => 22.2,
                'vat_percentage'    => 0.12,
                'total_price_after_discount_after_vat' => 23.3,
                'darbi_percentage'  => '',
                'charge_cc' => '',
                'charge_shop'   => ''
            ],
            'status_change_log' => [
                'old_status'    => '',
                'new_status'    => '',
                'created_at'    => '',
                'changed_by'    => [
                    'id'    => '',
                    'model' => ''
                ]
            ],
        ];
    }
}

