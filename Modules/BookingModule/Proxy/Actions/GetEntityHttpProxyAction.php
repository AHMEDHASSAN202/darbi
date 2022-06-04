<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\BookingModule\Proxy\Actions;

use Illuminate\Support\Facades\Http;

class GetEntityHttpProxyAction
{
    public function __invoke($data)
    {
        $url = env('MAIN_PROXY_URL') . '/api/mobile/v1/entities/' . $data['entity_id'];

        $res = Http::acceptJson()->withoutVerifying()->get($url);

        if ($res->status() !== 200) {
            return null;
        }

        return $res->json('data.entity');
    }
}
