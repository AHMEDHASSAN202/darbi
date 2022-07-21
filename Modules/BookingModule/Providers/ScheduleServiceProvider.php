<?php

namespace Modules\BookingModule\Providers;

use Closure;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\BookingModule\schedule\BookingTimeout;

class ScheduleServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }


    public function boot()
    {
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            $schedule->call(new BookingTimeout)->name('BookingTimeout')->everyMinute()->onOneServer();
        });
    }
}
