<?php

namespace Modules\BookingModule\Database\factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\AuthModule\Entities\User;
use Modules\AuthModule\Transformers\VendorResource;
use Modules\CatalogModule\Entities\Car;
use Modules\CatalogModule\Entities\Vendor;
use Modules\CatalogModule\Transformers\FindVendorResource;
use Modules\CommonModule\Entities\Country;
use Modules\CommonModule\Entities\Region;
use Modules\CommonModule\Transformers\CountryResource;
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
        $user = User::all()->random(1)->first();
        $ent = Car::withoutGlobalScope('car')->with(['model', 'brand', 'country', 'city'])->get()->random(1)->first();
        $region = Region::active()->get()->random(1)->first();

        return [
            'user_id'               => new ObjectId($user->_id),
            'user'                  => $user->only(['_id', 'phone', 'phone_code', 'name', 'email']),
            'vendor_id'             => new ObjectId($vendor->_id),
            'vendor'                => (new FindVendorResource($vendor))->toArray(request()),
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
            'drop_location_address' => [
                'lat'               => $this->faker->latitude,
                'lng'               => $this->faker->longitude,
                'fully_addressed'   => $this->faker->address,
                'city'              => $this->faker->city,
                'country'           => $this->faker->country,
                'state'             => $this->faker->streetAddress,
                'region_id'         => new ObjectId($region->_id)
            ],
            'entity_details'         => [
                'name'      => @$ent->name,
                'price'     => @$ent->price,
                'price_unit'=> @$ent->price_unit,
                'images'    => @$ent->images,
                'model_id'  => @$ent->model_id,
                'model_name'=> @$ent->model->name,
                'brand_id'  => @$ent->brand_id,
                'brand_name'=> @$ent->brand->name,
                'country'   => $ent->country->name,
                'extras'    => [],
            ],
            'invoice_number'         => \Str::random(),
            'price_summary'          => [
                'total_price'       => 100,
                'total_discount'    => 22.2,
                'discount_value'    => 22,
                'total_price_before_discount_before_vat' => 23.3,
                'total_price_after_discount_before_vat' => 23.3,
                'total_vat'         => 22.2,
                'vat_percentage'    => 0.12,
                'total_price_after_discount_after_vat' => 23.3,
                'darbi_percentage'  => '',
                'charge_cc' => '',
                'charge_shop'   => '',
                'vendor_price'  => 80,
                'darbi_price'   => 20
            ],
            'status' => ['pending','accepted','paid','cancelled_before_accept','cancelled_after_accept','rejected','picked_up','dropped','completed','force_cancelled'][mt_rand(0,9)],
            'rejected_reason' => '',
            'status_change_log' => [],
            'booking_dates_change_requests' => [],
            'pickup_location_change_requests' => [],
            'payment_method'        => [
                'type'  => ['cash','credit','applepay'][mt_rand(0,2)],
                'extra_info' => []
            ]
        ];
    }
}

