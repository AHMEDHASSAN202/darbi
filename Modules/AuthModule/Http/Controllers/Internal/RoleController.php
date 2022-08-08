<?php

namespace Modules\AuthModule\Http\Controllers\Internal;

use Illuminate\Routing\Controller;
use Modules\AuthModule\Services\RoleService;
use Modules\CommonModule\Traits\ApiResponseTrait;


class RoleController extends Controller
{
    use ApiResponseTrait;

    private $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function findVendorRole()
    {
        $result = $this->roleService->findVendorRole();

        return $this->apiResponse(...$result);
    }
}
