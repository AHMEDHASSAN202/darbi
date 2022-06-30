<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\AuthModule\Proxy\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class GetLocationHttpProxyAction
{
    public function __invoke($data)
    {
        $url = '/api/mobile/v1/locations/find?lat='.$data['lat'].'&lng='.$data['lng'];

        $req = Request::create($url, 'GET');

        $res = Route::dispatch($req);

        if ($res->status() !== 200) { return null; }

        $jsonData = json_decode($res->getContent(), true);

        return @$jsonData['data']['location'] ?? [];
    }
}
