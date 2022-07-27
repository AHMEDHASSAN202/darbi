<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\BookingModule\schedule;

use App\Proxy\Proxy;
use Modules\BookingModule\Proxy\BookingProxy;

class BookingTimeout
{
    public function __invoke()
    {
        $bookingProxy = new BookingProxy("TIMEOUT_BOOKINGS");

        $proxyResult = (new Proxy($bookingProxy))->result();

        if (!$proxyResult) {
            helperLog(__CLASS__, __FUNCTION__, 'TIMEOUT_BOOKINGS Proxy returned false');
        }
    }

}
