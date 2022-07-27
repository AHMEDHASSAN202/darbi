<?php

namespace Modules\BookingModule\Events;

use Illuminate\Queue\SerializesModels;
use Modules\BookingModule\Entities\Booking;

class BookingStatusChangedEvent
{
    use SerializesModels;

    public $booking;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }
}
