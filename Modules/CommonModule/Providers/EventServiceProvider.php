<?php

namespace Modules\CommonModule\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\CommonModule\Entities\Setting;
use Modules\CommonModule\Observers\SettingObserver;

class EventServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Setting::observe(SettingObserver::class);
    }
}
