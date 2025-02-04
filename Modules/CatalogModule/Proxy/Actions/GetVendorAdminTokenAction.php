<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Proxy\Actions;

use App\Proxy\InternalRequest;
use Illuminate\Support\Facades\Route;

class GetVendorAdminTokenAction
{
    public function __invoke($data)
    {
        $url = '/api/internal/v1/admins/'.$data['vendor_id'].'/token';

        $req = InternalRequest::create($url, 'GET', $data);

        $res = Route::dispatch($req);

        if ($res->status() !== 200) { return null; }

        $jsonData = json_decode($res->getContent(), true);

        return @$jsonData['data']['token'] ?? [];
    }
}
