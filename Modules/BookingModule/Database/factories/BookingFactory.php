<?php

namespace Modules\BookingModule\Database\factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\CatalogModule\Entities\Car;
use Modules\CatalogModule\Entities\Vendor;
use Modules\CommonModule\Entities\Country;
use Modules\CommonModule\Entities\Region;
use MongoDB\BSON\ObjectId;

class BookingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\BookingModule\Entities\Booking::class;

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
        $pluginPrice = $this->faker->randomFloat(2,3);

        return [
            'vendor_id'             => new ObjectId($vendor->_id),
            'branch_id'             => $branch ? new ObjectId($branch->_id): null,
            'country_id'            => new ObjectId($country->_id),
            'entity_id'             => new ObjectId($ent->_id),
            'entity_type'           => $ent->type,
            'start_booking_at'      => now()->subDay()->timestamp,
            'end_booking_at'        => now()->addMonth()->timestamp,
            'pickup_location_address'   => [
                'lat'               => $this->faker->latitude,
                'lng'               => $this->faker->longitude,
                'fully_addressed'   => $this->faker->address,
                'city'              => $this->faker->city,
                'country'           => $this->faker->country,
                'state'             => $this->faker->streetAddress,
                'region_id'         => new ObjectId($region->_id)
            ],
            'drop_location_address'  => [
                'lat'               => $this->faker->latitude,
                'lng'               => $this->faker->longitude,
                'fully_addressed'   => $this->faker->address,
                'city'              => $this->faker->city,
                'country'           => $this->faker->country,
                'state'             => $this->faker->streetAddress,
                'region_id'         => new ObjectId($region->_id)
            ],
            'entity_details'         => [
                'price'         => $ent->price,
                'price_unit'    => $ent->price_unit,
                'image'         =>  $this->faker->imageUrl(300, 300, 'car', false, 'Car'),
                'model_id'      => new ObjectId($ent->model_id),
                'model_name'    => ['ar' => translateAttribute($ent->model->name, 'ar'), 'en' => translateAttribute($ent->model->name, 'en')],
                'brand_id'      => new ObjectId($ent->brand_id),
                'brand_name'    => ['ar' => translateAttribute($ent->brand->name), 'en' => translateAttribute($ent->model->name, 'en')],
                'plugins'       => [['name' => ['ar' => $this->faker->text(10), 'en' => $this->faker->text(10)], 'price_per_day' => $pluginPrice]]
            ],
            'invoice_number'         => \Str::random(),
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
            'status' => ['pending','accepted','paid','cancelled_before_accept','cancelled_after_accept','rejected','picked_up','dropped','completed','force_cancelled'][mt_rand(0,9)],
            'status_change_log' => [
                [
                    'old_status'    => '',
                    'new_status'    => '',
                    'created_at'    => '',
                    'changed_by'    => [
                        'id'    => '',
                        'model' => ''
                    ]
                ]
            ],
            'booking_dates_change_requests' => [],
            'pickup_location_change_requests' => [],
            'payment_method'        => [
                'type'  => ['cash','credit','applepay'][mt_rand(0,2)],
                'extra_info' => []
            ]
        ];
    }
}

