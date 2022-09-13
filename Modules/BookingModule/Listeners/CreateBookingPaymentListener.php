<?php

namespace Modules\BookingModule\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\BookingModule\Enums\BookingStatus;
use Modules\BookingModule\Events\BookingStatusChangedEvent;
use Modules\BookingModule\Services\Admin\BookingPaymentTransactionService;

class CreateBookingPaymentListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(BookingStatusChangedEvent $event)
    {
        //create new payment when changed booking status paid
        if ($event->booking->status === BookingStatus::PAID) {
            app(BookingPaymentTransactionService::class)->createBookingPayment($event->booking, [], [], arrayGet($event->booking->payment_method, 'type'));
        }
    }
}
