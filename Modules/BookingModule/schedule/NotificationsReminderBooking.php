<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\BookingModule\schedule;

use App\Proxy\Proxy;
use Modules\BookingModule\Proxy\BookingProxy;

class NotificationsReminderBooking
{
    public function __invoke()
    {
        $bookingProxy = new BookingProxy("REMINDER_NOTIFICATION");

        $proxyResult = (new Proxy($bookingProxy))->result();

        if (!$proxyResult) {
            helperLog(__CLASS__, __FUNCTION__, 'REMINDER_NOTIFICATION Proxy returned false');
        }
    }

}
