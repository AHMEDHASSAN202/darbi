<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\BookingModule\Proxy\Actions;

use App\Proxy\InternalRequest;
use Illuminate\Support\Facades\Route;


class TimeoutBookingsHttpProxyAction
{
    public function __invoke($data)
    {
        $url = '/api/internal/v1/bookings/timeout';

        $req = InternalRequest::create($url, 'POST');

        $res = Route::dispatch($req);

        return $res->status() === 200;
    }
}
