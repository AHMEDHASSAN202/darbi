<?php

namespace Modules\AuthModule\Observers;

use Illuminate\Support\Facades\Log;
use Modules\AdminModule\Observers\Modules;
use Modules\AuthModule\Entities\Admin;
use function activities;

class AdminObserver
{
    /**
     * Handle the Role "created" event.
     *
     * @param  Modules\AdminModule\Entities\Admin  $admin
     * @return void
     */
    public function created(Admin $admin)
    {
        try {
            activities()->log('create', $admin, 'Create Admin');
        }catch (\Exception $exception) {
            Log::error("Can't log create admin", $admin->toArray());
        }
    }

    /**
     * Handle the Setting "updated" event.
     *
     * @param  Modules\AdminModule\Entities\Admin  $admin
     * @return void
     */
    public function updated(Admin $admin)
    {
        try {
            activities()->log('update', $admin, 'Update Admin');
        }catch (\Exception $exception) {
            Log::error("Can't log update admin", $admin->toArray());
        }
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
        try {
            activities()->log('delete', $admin, 'Delete Admin');
        }catch (\Exception $exception) {
            Log::error("Can't log delete admin", $admin->toArray());
        }
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
