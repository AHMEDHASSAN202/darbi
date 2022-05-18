<?php

namespace Modules\AuthModule\Http\Controllers\Role;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\AuthModule\Services\PermissionService;
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
            'permissions'   => $this->permissionService->findAll($request)
        ]);
    }
}
