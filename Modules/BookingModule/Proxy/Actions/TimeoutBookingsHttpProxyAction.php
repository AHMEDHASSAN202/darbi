<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\BookingModule\Proxy\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


class TimeoutBookingsHttpProxyAction
{
    public function __invoke($data)
    {
        $url = '/api/internal/v1/bookings/timeout';

        $req = Request::create($url, 'POST');

        $res = Route::dispatch($req);

        return $res->status() === 200;
    }
}
