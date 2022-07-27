<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\BookingModule\Proxy\Actions;

use App\Proxy\InternalRequest;
use Illuminate\Support\Facades\Route;


class ChangeEntityStateToReservedHttpProxyAction
{
    public function __invoke($data)
    {
        $url = '/api/internal/v1/entities/' . $data['entity_id'] . '/state/reserved';

        $req = InternalRequest::create($url, 'PUT');

        $res = Route::dispatch($req);

        if ($res->status() !== 200) {
            return false;
        }

        return true;
    }
}
