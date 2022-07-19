<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\BookingModule\Proxy;

use App\Proxy\BaseProxy;
use Modules\BookingModule\Proxy\Actions\CreateNotificationHttpProxyAction;
use Modules\BookingModule\Proxy\Actions\GetCityHttpProxyAction;
use Modules\BookingModule\Proxy\Actions\GetEntityHttpProxyAction;
use Modules\BookingModule\Proxy\Actions\GetVendorHttpProxyAction;
use Modules\BookingModule\Proxy\Actions\UpdateEntityStateHttpProxyAction;

class BookingProxy extends BaseProxy
{
    protected $actions = [
        'GET_ENTITY'            => GetEntityHttpProxyAction::class,
        'GET_VENDOR'            => GetVendorHttpProxyAction::class,
        'GET_CITY'              => GetCityHttpProxyAction::class,
        'CREATE_NOTIFICATION'   => CreateNotificationHttpProxyAction::class,
        'UPDATE_ENTITY_STATE'   => UpdateEntityStateHttpProxyAction::class
    ];
}
