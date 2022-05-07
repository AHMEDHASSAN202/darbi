<?php

namespace Modules\AdminModule\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\AdminModule\Entities\Admin;
use Modules\AdminModule\Entities\Role;
use Modules\AdminModule\Observers\AdminObserver;
use Modules\AdminModule\Observers\RoleObserver;


class EventServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Role::observe(RoleObserver::class);
        Admin::observe(AdminObserver::class);
    }
}
