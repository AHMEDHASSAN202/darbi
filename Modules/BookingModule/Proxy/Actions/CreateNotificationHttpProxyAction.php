<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\BookingModule\Proxy\Actions;

use App\Proxy\InternalRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;


class CreateNotificationHttpProxyAction
{
    public function __invoke($data)
    {
        $url = '/api/admin/v1/notifications';

        $originalRequest = request();

        $req = InternalRequest::create($url, 'POST', $data);

        app()->instance('request', $req);

        $res = Route::dispatch($req);

        app()->instance('request', $originalRequest);

        if ($res->status() !== 201) {
            Log::error(json_encode($res));
            return null;
        }

        $jsonData = json_decode($res->getContent(), true);

        return @$jsonData['data']['id'] ?? null;
    }
}
