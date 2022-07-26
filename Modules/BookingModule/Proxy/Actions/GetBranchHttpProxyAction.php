<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\BookingModule\Proxy\Actions;

use App\Proxy\InternalRequest;
use Illuminate\Support\Facades\Route;


class GetBranchHttpProxyAction
{
    public function __invoke($data)
    {
        $url = '/api/internal/v1/branches/' . $data['branch_id'];

        $req = InternalRequest::create($url, 'GET');

        $res = Route::dispatch($req);

        if ($res->status() !== 200) { return null; }

        $jsonData = json_decode($res->getContent(), true);

        return @$jsonData['data']['branch'] ?? [];
    }
}
