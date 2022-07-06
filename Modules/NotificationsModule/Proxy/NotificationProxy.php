<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\NotificationsModule\Proxy;

use App\Proxy\BaseProxy;
use Modules\NotificationsModule\Proxy\Actions\GetUsersAction;
use Modules\NotificationsModule\Proxy\Actions\GetVendorAdminsAction;

class NotificationProxy extends BaseProxy
{
    protected $actions = [
        'GET_USERS'         => GetUsersAction::class,
        'GET_VENDOR_ADMIN'  => GetVendorAdminsAction::class
    ];
}
