<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\BookingModule\Proxy\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


class ChangeEntityStateToReservedHttpProxyAction
{
    public function __invoke($data)
    {
        $url = '/api/mobile/v1/entities/' . $data['entity_id'] . '/state/reserved';

        $req = Request::create($url, 'PUT');

        $res = Route::dispatch($req);

        if ($res->status() !== 200) {
            return false;
        }

        return true;
    }
}
