<?php

namespace Modules\BookingModule\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\BookingModule\Entities\Booking;
use Modules\BookingModule\Entities\BookingPaymentTransaction;
use Modules\BookingModule\Entities\Cart;

class BookingModuleDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        Cart::factory()->count(100)->create();
        Booking::factory()->count(200)->create();
        BookingPaymentTransaction::factory()->count(200)->create();
    }
}
