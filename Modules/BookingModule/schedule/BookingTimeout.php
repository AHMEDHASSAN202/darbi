<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\BookingModule\schedule;

use App\Proxy\Proxy;
use Illuminate\Support\Facades\Log;
use Modules\BookingModule\Proxy\BookingProxy;

class BookingTimeout
{
    public function __invoke()
    {
        Log::info('TESSSSSSSSSSSSSSSST');
        $bookingProxy = new BookingProxy("TIMEOUT_BOOKINGS");

        $proxyResult = (new Proxy($bookingProxy))->result();

        if (!$proxyResult) {
            helperLog(__CLASS__, __FUNCTION__, 'TIMEOUT_BOOKINGS Proxy returned false');
        }
    }

}
