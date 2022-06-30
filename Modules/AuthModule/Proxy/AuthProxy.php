<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\AuthModule\Proxy;

use App\Proxy\BaseProxy;
use Modules\AuthModule\Proxy\Actions\GetLocationHttpProxyAction;
use Modules\AuthModule\Proxy\Actions\GetRegionHttpProxyAction;

class AuthProxy extends BaseProxy
{
    protected $action = [
        'GET_LOCATION'      => GetLocationHttpProxyAction::class,
        'GET_REGION'        => GetRegionHttpProxyAction::class,
    ];
}
