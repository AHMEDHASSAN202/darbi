<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\BookingModule\Proxy\Actions;

use Illuminate\Support\Facades\Http;

class GetCarHttpProxyAction
{
    private $GET_CAR_REQUEST;

    public function __construct()
    {
        $this->GET_CAR_REQUEST = 'http://127.0.0.1:8000/api/mobile/v1/cars';
    }

    public function __invoke($data)
    {
        return Http::acceptJson()->withOptions(['proxy' => 'http://127.0.0.1:8000'])->withoutVerifying()->get($this->GET_CAR_REQUEST . '/' . $data['entity_id'])->json();
    }
}
