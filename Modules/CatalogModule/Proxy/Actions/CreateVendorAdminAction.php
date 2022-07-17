<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Proxy\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class CreateVendorAdminAction
{
    public function __invoke($data)
    {
        $url = '/api/admin/v1/admins';

        $originalRequest = request();

        $request = Request::create($url,'POST', $data);

        app()->instance('request', $request);

        $response = Route::dispatch($request);

        app()->instance('request', $originalRequest);

        if ($response->status() !== 201) { return null; }

        $jsonData = json_decode($response->getContent(), true);

        return @$jsonData['data'] ?? null;
    }
}
