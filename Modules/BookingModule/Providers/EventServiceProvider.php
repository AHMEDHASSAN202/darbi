<?php

namespace Modules\BookingModule\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\BookingModule\Entities\Booking;
use Modules\BookingModule\Observers\BookingObserver;

class EventServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Booking::observe(BookingObserver::class);
    }
}
