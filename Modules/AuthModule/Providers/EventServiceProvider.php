<?php

namespace Modules\AuthModule\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\AuthModule\Entities\Admin;
use Modules\AuthModule\Entities\Role;
use Modules\AuthModule\Observers\AdminObserver;
use Modules\AuthModule\Observers\RoleObserver;

class EventServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Role::observe(RoleObserver::class);
        Admin::observe(AdminObserver::class);
    }
}
