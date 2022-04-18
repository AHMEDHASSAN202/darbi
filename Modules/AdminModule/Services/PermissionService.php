<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\AdminModule\Services;

use Modules\AdminModule\Transformers\RoleCollection;


class PermissionService
{
    public function list($request)
    {
        return config('adminmodule.permissions');
    }
}
