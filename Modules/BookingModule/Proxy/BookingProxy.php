<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\BookingModule\Proxy;

use App\Proxy\BaseProxy;
use Modules\BookingModule\Proxy\Actions\ChangeEntityStateToReservedHttpProxyAction;
use Modules\BookingModule\Proxy\Actions\GetEntityHttpProxyAction;
use Modules\BookingModule\Proxy\Actions\GetVendorHttpProxyAction;

class BookingProxy extends BaseProxy
{
    protected $actions = [
        'GET_ENTITY'           => GetEntityHttpProxyAction::class,
        'CHANGE_ENTITY_STATE_TO_RESERVED'   => ChangeEntityStateToReservedHttpProxyAction::class,
        'GET_VENDOR'            => GetVendorHttpProxyAction::class
//        'GET_ENTITY'           => GetCarRedisProxyAction::class,
    ];
}
