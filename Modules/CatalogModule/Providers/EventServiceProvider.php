<?php

namespace Modules\CatalogModule\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\CatalogModule\Entities\Car;
use Modules\CatalogModule\Entities\Yacht;
use Modules\CatalogModule\Observers\CarObserver;
use Modules\CatalogModule\Observers\YachtObserver;

class EventServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Car::observe(CarObserver::class);
        Yacht::observe(YachtObserver::class);
    }
}
