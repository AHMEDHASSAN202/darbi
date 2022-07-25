<?php

namespace Modules\AuthModule\Observers;


use Modules\AuthModule\Entities\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  \Modules\AuthModule\Entities\User $user
     * @return void
     */
    public function created(User $user)
    {
        //
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \Modules\AuthModule\Entities\User $user
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \Modules\AuthModule\Entities\User $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the User "restored" event.
     *
     * @param  \Modules\AuthModule\Entities\User $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param  \Modules\AuthModule\Entities\User $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
