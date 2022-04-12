<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\AdminModule\Services;

use Modules\AdminModule\Repositories\RoleRepository;
use Modules\AdminModule\Transformers\RoleCollection;
use Modules\AdminModule\Transformers\RoleResource;
use Modules\CommonModule\Transformers\PaginateResource;

/**
 * @group Role
 * @authenticated
 * Management Roles and Permmissions
 */
class RoleService
{
    private $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * List of roles
     *
     * @queryParam q string
     * get roles. If everything is okay, you'll get a 200 OK response and addresses.
     * Otherwise, the request will fail with a 400 || 422 || 500 error
     */
    public function getList($request)
    {
        $limit = $request->get('limit', 20);
        $roles = $this->roleRepository->list($limit, 'adminSearch');

        return new PaginateResource(RoleResource::collection($roles));
    }
}
