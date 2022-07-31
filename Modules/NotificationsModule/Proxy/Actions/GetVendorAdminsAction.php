<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\NotificationsModule\Proxy\Actions;

use App\Proxy\InternalRequest;
use Illuminate\Support\Facades\Route;

class GetVendorAdminsAction
{
    public function __invoke($data)
    {
        $url = '/api/internal/v1/admins/ids';

        $originalRequest = request();

        $req = InternalRequest::create($url, 'GET', $data);

        app()->instance('request', $req);

        $res = Route::dispatch($req);

        app()->instance('request', $originalRequest);

        if ($res->status() !== 200) { return null; }

        $jsonData = json_decode($res->getContent(), true);

        return @$jsonData['data']['admins'] ?? [];
    }
}
