<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\BookingModule\Proxy;

use App\Proxy\BaseProxy;
use Modules\BookingModule\Proxy\Actions\GetCarHttpProxyAction;
use Modules\BookingModule\Proxy\Actions\GetCarRedisProxyAction;

class BookingProxy extends BaseProxy
{
    protected $actions = [
        'GET_CAR'           => GetCarHttpProxyAction::class,
//        'GET_CAR'           => GetCarRedisProxyAction::class,
    ];
}
