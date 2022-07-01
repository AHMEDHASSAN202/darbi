<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Proxy\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class CreateVendorAdmin
{
    public function __invoke($data)
    {
        $url = '/api/admin/v1/admins';

        $req = Request::create($url, 'POST', $data);

        $res = Route::dispatch($req);

        if ($res->status() !== 200) { return null; }

        $jsonData = json_decode($res->getContent(), true);

        return @$jsonData['data']['id'] ?? null;
    }
}
