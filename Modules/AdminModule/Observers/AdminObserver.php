<?php

namespace Modules\AdminModule\Observers;

use Modules\AdminModule\Entities\Admin;
use Modules\CommonModule\Traits\ApiResponseTrait;

class AdminObserver
{
    /**
     * Handle the Role "created" event.
     *
     * @param  Modules\AdminModule\Entities\Admin  $admin
     * @return void
     */
    public function created(Admin $role)
    {

    }

    /**
     * Handle the Role "deleting" event.
     *
     * @param  Modules\AdminModule\Entities\Admin  $admin
     * @return void
     */
    public function deleting(Admin $admin)
    {

    }

    /**
     * Handle the Role "deleted" event.
     *
     * @param  Modules\AdminModule\Entities\Admin  $admin
     * @return void
     */
    public function deleted(Admin $admin)
    {

    }


    /**
     * Handle the Role "restored" event.
     *
     * @param Modules\AdminModule\Entities\Admin  $admin
     * @return void
     */
    public function restored(Admin $admin)
    {
        //
    }

    /**
     * Handle the Role "force deleted" event.
     *
     * @param  Modules\AdminModule\Entities\Admin  $admin
     * @return void
     */
    public function forceDeleted(Admin $admin)
    {
        //
    }
}
