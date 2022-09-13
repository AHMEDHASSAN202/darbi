<?php

namespace Modules\BookingModule\Providers;


use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\BookingModule\Entities\Booking;
use Modules\BookingModule\Events\BookingStatusChangedEvent;
use Modules\BookingModule\Listeners\CreateBookingPaymentListener;
use Modules\BookingModule\Listeners\SendNotificationListener;
use Modules\BookingModule\Listeners\UpdateEntityStateListener;
use Modules\BookingModule\Observers\BookingObserver;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        BookingStatusChangedEvent::class => [
            CreateBookingPaymentListener::class,
            SendNotificationListener::class,
        ]
    ];

    public function boot()
    {
        Booking::observe(BookingObserver::class);
    }
}
