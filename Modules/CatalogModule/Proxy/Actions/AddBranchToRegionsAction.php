<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Proxy\Actions;

use App\Proxy\InternalRequest;
use Illuminate\Support\Facades\Route;

class AddBranchToRegionsAction
{
    public function __invoke($data)
    {
        $url = '/api/internal/v1/regions/add-branch';

        $originalRequest = request();

        $req = InternalRequest::create($url, "POST", $data);

        app()->instance('request', $req);

        $res = Route::dispatch($req);

        app()->instance('request', $originalRequest);

        return $res->status() === 200;
    }
}
