<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\BookingModule\Proxy;

use App\Proxy\BaseProxy;
use Modules\BookingModule\Proxy\Actions\GetEntityHttpProxyAction;
use Modules\BookingModule\Proxy\Actions\GetCarRedisProxyAction;

class BookingProxy extends BaseProxy
{
    protected $actions = [
        'GET_ENTITY'           => GetEntityHttpProxyAction::class,
//        'GET_ENTITY'           => GetCarRedisProxyAction::class,
    ];
}
