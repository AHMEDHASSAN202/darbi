<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\NotificationsModule\Proxy\Actions;

use App\Proxy\InternalRequest;
use Illuminate\Support\Facades\Route;

class GetUsersAction
{
    public function __invoke($data)
    {
        $url = '/api/internal/v1/users/ids';

        $originalRequest = request();

        $req = InternalRequest::create($url, 'GET', $data, [],  ['users_file' => $data['users_file'] ?? []]);

        app()->instance('request', $req);

        $res = Route::dispatch($req);

        app()->instance('request', $originalRequest);

        if ($res->status() !== 200) { return null; }

        $jsonData = json_decode($res->getContent(), true);

        return @$jsonData['data']['users'] ?? [];
    }
}
