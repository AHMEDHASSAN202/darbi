<?php

namespace Modules\BookingModule\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\BookingModule\Entities\Booking;
use Modules\BookingModule\Enums\BookingStatus;
use Modules\CatalogModule\Entities\Vendor;
use MongoDB\BSON\ObjectId;

class BookingPaymentTransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\BookingModule\Entities\BookingPaymentTransaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $vendor = Vendor::all()->random(1)->first();
        $booking = Booking::whereIn('status', [BookingStatus::PAID, BookingStatus::DROPPED, BookingStatus::PICKED_UP, BookingStatus::COMPLETED])->where('vendor_id', new ObjectId($vendor->_id))->get();
        if (!$booking->count()) {
            return [];
        }
        $booking = $booking->random(1)->first();
        return [
            'vendor_id'  => new ObjectId($vendor->_id),
            'booking_id' => new ObjectId($booking->_id),
            'entity_id'  => $booking->entity_id,
            'name'       => $booking->entity_details['name'],
            'amount'     => $booking->price_summary['total_price'],
            'req'        => [],
            'res'        => [],
            'status'     => $this->faker->boolean,
            'payment_method' => 'applypay'
        ];
    }
}

