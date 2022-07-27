<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\BookingModule\Proxy\Actions;

use App\Proxy\InternalRequest;
use Illuminate\Support\Facades\Route;


class NotificationReminderBookingsHttpProxyAction
{
    public function __invoke($data)
    {
        $url = '/api/internal/v1/bookings/reminder';

        $req = InternalRequest::create($url, 'POST');

        $res = Route::dispatch($req);

        return $res->status() === 200;
    }
}
