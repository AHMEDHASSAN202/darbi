<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Proxy\Actions;

use App\Proxy\InternalRequest;
use Illuminate\Support\Facades\Route;

class GetRegionsAction
{
    public function __invoke($data)
    {
        $url = '/api/internal/v1/regions';

        $originalRequest = request();

        $req = InternalRequest::create($url, "GET", $data);

        app()->instance('request', $req);

        $res = Route::dispatch($req);

        app()->instance('request', $originalRequest);

        if ($res->status() !== 200) { return null; }

        $jsonData = json_decode($res->getContent(), true);

        return @$jsonData['data']['regions'] ?? [];
    }
}
