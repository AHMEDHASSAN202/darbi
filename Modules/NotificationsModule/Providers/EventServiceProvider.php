<?php

namespace Modules\NotificationsModule\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\NotificationsModule\Entities\NotificationsCenter;
use Modules\NotificationsModule\Observers\NotificationObserver;

class EventServiceProvider extends ServiceProvider
{
    public function boot()
    {
        NotificationsCenter::observe(NotificationObserver::class);
    }
}
