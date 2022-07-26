<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Proxy\Actions;

use App\Proxy\InternalRequest;
use Illuminate\Support\Facades\Route;

class GetCountryAction
{
    public function __invoke($data)
    {
        $url = '/api/internal/v1/countries/' . $data['country_id'];

        $req = InternalRequest::create($url, "GET", $data);

        $res = Route::dispatch($req);

        if ($res->status() !== 200) { return null; }

        $jsonData = json_decode($res->getContent(), true);

        return @$jsonData['data']['country'] ?? [];
    }
}
