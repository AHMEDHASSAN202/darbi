<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\BookingModule\Proxy\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


class UpdateEntityStateHttpProxyAction
{
    public function __invoke($data)
    {
        $url = '/api/mobile/v1/entities/' . $data['id'] . '/' . $data['state'];

        $originalRequest = request();

        $req = Request::create($url, 'PUT');

        app()->instance('request', $req);

        $res = Route::dispatch($req);

        app()->instance('request', $originalRequest);

        if ($res->status() !== 200) { return null; }

        $jsonData = json_decode($res->getContent(), true);

        return @$jsonData['data']['id'] ?? null;
    }
}
