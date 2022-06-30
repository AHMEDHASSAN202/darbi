<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Proxy\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class GetRegionAction
{
    public function __invoke($data)
    {
        $url = '/api/mobile/v1/regions/find';

        $req = Request::create($url, 'GET', $data);

        $res = Route::dispatch($req);

        if ($res->status() !== 200) { return null; }

        $jsonData = json_decode($res->getContent(), true);

        return @$jsonData['data']['region'] ?? [];
    }
}
