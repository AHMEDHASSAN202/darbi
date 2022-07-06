<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Proxy;

use App\Proxy\BaseProxy;
use Modules\CatalogModule\Proxy\Actions\CreateVendorAdminAction;
use Modules\CatalogModule\Proxy\Actions\GetRegionAction;
use Modules\CatalogModule\Proxy\Actions\GetVendorAdminsAction;
use Modules\CatalogModule\Proxy\Actions\GetUsersAction;
use Modules\CatalogModule\Proxy\Actions\SendNotificationAction;

class CatalogProxy extends BaseProxy
{
    protected $actions = [
        'GET_REGION'           => GetRegionAction::class,
        'GET_VENDOR_ROLE'      => GetUsersAction::class,
        'CREATE_VENDOR_ADMIN'  => CreateVendorAdminAction::class,
        'GET_VENDOR_ADMIN_TOKEN'=> GetVendorAdminsAction::class,
        'SEND_NOTIFICATION'     => SendNotificationAction::class,
    ];
}
