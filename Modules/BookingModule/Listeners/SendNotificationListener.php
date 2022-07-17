<?php

namespace Modules\BookingModule\Listeners;

use App\Proxy\Proxy;
use Modules\BookingModule\Events\BookingStatusChangedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\BookingModule\Proxy\BookingProxy;

class SendNotificationListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param BookingStatusChangedEvent $event
     * @return void
     */
    public function handle(BookingStatusChangedEvent $event)
    {
        $bookingProxy = new BookingProxy('CREATE_NOTIFICATION', [
            'title'         => ['ar' => '', 'en' => ''],
            'message'       => ['ar' => '', 'en' => ''],
            'notification_type' => 'booking',
            'receivers'         => [['id' => '', 'type' => '']],
            'extra_data'        => ['booking_id' => $event->booking->id],
            'is_automatic'      => true,
        ]);

        $proxy = new Proxy($bookingProxy);

        $notificationId = $proxy->result();

        if (!$notificationId) {
            helperLog(__CLASS__, __FUNCTION__, "Can't create notification");
        }
    }
}
