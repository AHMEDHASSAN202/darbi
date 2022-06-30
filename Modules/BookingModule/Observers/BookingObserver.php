<?php

namespace Modules\BookingModule\Observers;

use Modules\BookingModule\Entities\Booking;

class BookingObserver
{
    /**
     * Handle the Booking "created" event.
     *
     * @param  Booking  $booking
     * @return void
     */
    public function created(Booking $booking)
    {

    }

    /**
     * Handle the Booking "updated" event.
     *
     * @param  Booking  $booking
     * @return void
     */
    public function updated(Booking $booking)
    {

    }

    /**
     * Handle the Booking "deleted" event.
     *
     * @param  Modules\BookingModule\Entities\Booking  $booking
     * @return void
     */
    public function deleted(Booking $booking)
    {
        //
    }

    /**
     * Handle the Booking "restored" event.
     *
     * @param  Booking  $booking
     * @return void
     */
    public function restored(Booking $booking)
    {
        //
    }

    /**
     * Handle the Booking "force deleted" event.
     *
     * @param  Booking  $booking
     * @return void
     */
    public function forceDeleted(Booking $booking)
    {
        //
    }
}
