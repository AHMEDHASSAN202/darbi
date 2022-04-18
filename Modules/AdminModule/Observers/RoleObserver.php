<?php

namespace Modules\AdminModule\Observers;

use Modules\AdminModule\Entities\Role;

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
