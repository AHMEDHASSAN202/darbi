<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\AuthModule\Services;

use Modules\AdminModule\Transformers\RoleCollection;


class PermissionService
{
    public function findAll($request)
    {
        return config('authmodule.permissions');
    }
}
