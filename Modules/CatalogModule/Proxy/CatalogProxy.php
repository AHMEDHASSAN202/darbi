<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Proxy;

use App\Proxy\BaseProxy;
use Modules\BookingModule\Proxy\Actions\ChangeEntityStateToReservedHttpProxyAction;
use Modules\BookingModule\Proxy\Actions\GetEntityHttpProxyAction;
use Modules\CatalogModule\Proxy\Actions\GetRegionAction;

class CatalogProxy extends BaseProxy
{
    protected $actions = [
        'GET_REGION'           => GetRegionAction::class,
    ];
}
