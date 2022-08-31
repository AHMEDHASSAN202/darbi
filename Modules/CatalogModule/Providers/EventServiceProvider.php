<?php

namespace Modules\CatalogModule\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\CatalogModule\Entities\Attribute;
use Modules\CatalogModule\Entities\Branch;
use Modules\CatalogModule\Entities\Car;
use Modules\CatalogModule\Entities\Villa;
use Modules\CatalogModule\Entities\Yacht;
use Modules\CatalogModule\Observers\AttributeObserver;
use Modules\CatalogModule\Observers\BranchObserver;
use Modules\CatalogModule\Observers\CarObserver;
use Modules\CatalogModule\Observers\VillaObserver;
use Modules\CatalogModule\Observers\YachtObserver;

class EventServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Car::observe(CarObserver::class);
        Yacht::observe(YachtObserver::class);
        Villa::observe(VillaObserver::class);
        Branch::observe(BranchObserver::class);
        Attribute::observe(AttributeObserver::class);
    }
}
