<?php

namespace Modules\NotificationsModule\Observers;

use Modules\NotificationsModule\Entities\NotificationsCenter;
use Modules\NotificationsModule\Jobs\SendNotificationJob;

class NotificationObserver
{
    /**
     * Handle the NotificationsCenter "created" event.
     *
     * @param  \Modules\NotificationsModule\Entities\NotificationsCenter  $notificationsCenter
     * @return void
     */
    public function created(NotificationsCenter $notificationsCenter)
    {
        SendNotificationJob::dispatchSync($notificationsCenter);
    }

    /**
     * Handle the NotificationsCenter "updated" event.
     *
     * @param  \Modules\NotificationsModule\Entities\NotificationsCenter  $notificationsCenter
     * @return void
     */
    public function updated(NotificationsCenter $notificationsCenter)
    {
        //
    }

    /**
     * Handle the NotificationsCenter "deleted" event.
     *
     * @param  \Modules\NotificationsModule\Entities\NotificationsCenter  $notificationsCenter
     * @return void
     */
    public function deleted(NotificationsCenter $notificationsCenter)
    {
        //
    }

    /**
     * Handle the NotificationsCenter "restored" event.
     *
     * @param  \Modules\NotificationsModule\Entities\NotificationsCenter  $notificationsCenter
     * @return void
     */
    public function restored(NotificationsCenter $notificationsCenter)
    {
        //
    }

    /**
     * Handle the NotificationsCenter "force deleted" event.
     *
     * @param  \Modules\NotificationsModule\Entities\NotificationsCenter  $notificationsCenter
     * @return void
     */
    public function forceDeleted(NotificationsCenter $notificationsCenter)
    {
        //
    }
}
