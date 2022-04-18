<?php

namespace Modules\AdminModule\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\AdminModule\Http\Requests\CreateRoleRequest;
use Modules\AdminModule\Http\Requests\UpdateRoleRequest;
use Modules\AdminModule\Services\PermissionService;
use Modules\AdminModule\Services\RoleService;
use Modules\CommonModule\Traits\ApiResponseTrait;

/**
 * @group Roles
 */
class PermissionController extends Controller
{
    use ApiResponseTrait;

    private $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    /**
     * List of permissions
     *
     * get permissions. If everything is okay, you'll get a 200 OK response.
     * Otherwise, the request will fail with a 400 || 422 || 500 error
     */
    public function index(Request $request)
    {
        return $this->apiResponse([
            'permissions'   => $this->permissionService->list($request)
        ]);
    }
}
