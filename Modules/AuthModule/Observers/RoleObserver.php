<?php

namespace Modules\AuthModule\Observers;

use Illuminate\Support\Facades\Log;
use Modules\AdminModule\Observers\Modules;
use Modules\AuthModule\Entities\Role;
use function activities;

class RoleObserver
{
    /**
     * Handle the Role "created" event.
     *
     * @param  Modules\AdminModule\Entities\Role  $role
     * @return void
     */
    public function created(Role $role)
    {
        try {
            activities()->log('create', $role, 'Create Role');
        }catch (\Exception $exception) {
            Log::error("Can't log create role", $role->toArray());
        }
    }

    /**
     * Handle the Setting "updated" event.
     *
     * @param  Modules\AdminModule\Entities\Role  $role
     * @return void
     */
    public function updated(Role $role)
    {
        try {
            activities()->log('update', $role, 'Update Role');
        }catch (\Exception $exception) {
            Log::error("Can't log update role", $role->toArray());
        }
    }

    /**
     * Handle the Role "deleting" event.
     *
     * @param  Modules\AdminModule\Entities\Role  $role
     * @return void
     */
    public function deleting(Role $role)
    {

    }

    /**
     * Handle the Role "deleted" event.
     *
     * @param  Modules\AdminModule\Entities\Role  $role
     * @return void
     */
    public function deleted(Role $role)
    {
        try {
            activities()->log('delete', $role, 'Delete Role');
        }catch (\Exception $exception) {
            Log::error("Can't log delete role", $role->toArray());
        }
    }


    /**
     * Handle the Role "restored" event.
     *
     * @param Modules\AdminModule\Entities\Role  $role
     * @return void
     */
    public function restored(Role $role)
    {
        //
    }

    /**
     * Handle the Role "force deleted" event.
     *
     * @param  Modules\AdminModule\Entities\Role  $role
     * @return void
     */
    public function forceDeleted(Role $role)
    {
        //
    }
}
