<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Proxy;

use App\Proxy\BaseProxy;
use Modules\CatalogModule\Proxy\Actions\AddBranchToRegionsAction;
use Modules\CatalogModule\Proxy\Actions\CreateVendorAdminAction;
use Modules\CatalogModule\Proxy\Actions\GetRegionsAction;
use Modules\CatalogModule\Proxy\Actions\GetVendorAdminTokenAction;
use Modules\CatalogModule\Proxy\Actions\GetVendorRoleAction;
use Modules\CatalogModule\Proxy\Actions\RemoveBranchToRegionsAction;
use Modules\CatalogModule\Proxy\Actions\SendNotificationAction;

class CatalogProxy extends BaseProxy
{
    protected $actions = [
        'GET_REGIONS'          => GetRegionsAction::class,
        'GET_VENDOR_ROLE'      => GetVendorRoleAction::class,
        'CREATE_VENDOR_ADMIN'  => CreateVendorAdminAction::class,
        'GET_VENDOR_ADMIN_TOKEN'=> GetVendorAdminTokenAction::class,
        'ADD_BRANCH_TO_REGIONS' => AddBranchToRegionsAction::class,
        'REMOVE_BRANCH_FROM_REGIONS' => RemoveBranchToRegionsAction::class
    ];
}
