<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Proxy\Actions;

use App\Proxy\InternalRequest;
use Illuminate\Support\Facades\Route;

class GetLocationHttpProxyAction
{
    public function __invoke($data)
    {
        $url = '/api/internal/v1/locations/find?lat='.$data['lat'].'&lng='.$data['lng'];

        $req = InternalRequest::create($url, 'GET');

        $res = Route::dispatch($req);

        if ($res->status() !== 200) { return null; }

        $jsonData = json_decode($res->getContent(), true);

        return @$jsonData['data']['location'] ?? [];
    }
}
