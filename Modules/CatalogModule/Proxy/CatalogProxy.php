<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Proxy;

use App\Proxy\BaseProxy;
use Modules\CatalogModule\Proxy\Actions\CreateVendorAdminAction;
use Modules\CatalogModule\Proxy\Actions\GetRegionAction;
use Modules\CatalogModule\Proxy\Actions\GetVendorAdminTokenAction;
use Modules\CatalogModule\Proxy\Actions\GetVendorRoleAction;

class CatalogProxy extends BaseProxy
{
    protected $actions = [
        'GET_REGION'           => GetRegionAction::class,
        'GET_VENDOR_ROLE'      => GetVendorRoleAction::class,
        'CREATE_VENDOR_ADMIN'  => CreateVendorAdminAction::class,
        'GET_VENDOR_ADMIN_TOKEN'=> GetVendorAdminTokenAction::class,
    ];
}
