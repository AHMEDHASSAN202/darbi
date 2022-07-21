<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\NotificationsModule\Proxy\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class GetUsersAction
{
    public function __invoke($data)
    {
        $url = '/api/internal/v1/users/ids';

        $originalRequest = request();

        $req = Request::create($url, 'GET', $data);

        app()->instance('request', $req);

        $res = Route::dispatch($req);

        app()->instance('request', $originalRequest);

        if ($res->status() !== 200) { return null; }

        $jsonData = json_decode($res->getContent(), true);

        return @$jsonData['data']['users'] ?? [];
    }
}
