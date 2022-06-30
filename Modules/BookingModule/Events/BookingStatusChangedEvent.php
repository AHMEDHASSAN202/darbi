<?php

namespace Modules\BookingModule\Events;

use Illuminate\Queue\SerializesModels;
use Modules\BookingModule\Entities\Booking;

class BookingStatusChangedEvent
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Booking $booking)
    {

    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
