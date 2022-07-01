<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Proxy;

use App\Proxy\BaseProxy;
use Modules\BookingModule\Proxy\Actions\ChangeEntityStateToReservedHttpProxyAction;
use Modules\BookingModule\Proxy\Actions\GetEntityHttpProxyAction;
use Modules\CatalogModule\Proxy\Actions\CreateVendorAdmin;
use Modules\CatalogModule\Proxy\Actions\GetRegionAction;
use Modules\CatalogModule\Proxy\Actions\GetVendorRole;

class CatalogProxy extends BaseProxy
{
    protected $actions = [
        'GET_REGION'           => GetRegionAction::class,
        'GET_VENDOR_ROLE'      => GetVendorRole::class,
        'CREATE_VENDOR_ADMIN'  => CreateVendorAdmin::class
    ];
}
