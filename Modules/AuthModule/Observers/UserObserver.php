<?php

namespace Modules\AuthModule\Observers;


use Modules\AuthModule\Entities\User;

class UserObserver
{
    /**
     * Handle the Vendor "created" event.
     *
     * @param  \Modules\AuthModule\Entities\User $user
     * @return void
     */
    public function created(User $user)
    {
        //
    }

    /**
     * Handle the Vendor "updated" event.
     *
     * @param  \Modules\AuthModule\Entities\User $user
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

    /**
     * Handle the Vendor "deleted" event.
     *
     * @param  \Modules\AuthModule\Entities\User $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the Vendor "restored" event.
     *
     * @param  \Modules\AuthModule\Entities\User $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the Vendor "force deleted" event.
     *
     * @param  \Modules\AuthModule\Entities\User $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
