<?php

namespace Modules\CommonModule\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\CommonModule\Entities\Setting;
use Modules\CommonModule\Observers\SettingObserver;

class EventServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Setting::observe(SettingObserver::class);
    }
}
