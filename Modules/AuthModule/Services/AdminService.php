<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\AuthModule\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Modules\AdminModule\Transformers\RoleCollection;
use Modules\AuthModule\Repositories\Admin\AdminRepository;
use Modules\AuthModule\Transformers\ActivityResource;
use Modules\AuthModule\Transformers\AdminResource;
use Modules\CommonModule\Services\ActivityService;
use Modules\CommonModule\Transformers\PaginateResource;

class AdminService
{
    private $adminRepository;

    public function __construct(AdminRepository $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    public function findAll(Request $request)
    {
        $admins = $this->adminRepository->list($request, $request->get('limit', 20));

        return new PaginateResource(AdminResource::collection($admins));
    }

    public function create($request)
    {
        $admin = $this->adminRepository->create([
            'name'      => $request->name,
            'email'     => $request->email,
            'role_id'   => $request->role_id,
            'password'  => Hash::make($request->password)
        ]);

        return new AdminResource($admin);
    }

    public function update($adminId, $request)
    {
        $admin = $this->adminRepository->update($adminId, [
            'name'      => $request->name,
            'email'     => $request->email,
            'role_id'   => $request->role_id
        ]);

        return new AdminResource($admin);
    }

    public function updatePassword($adminId, $request)
    {
        $admin = $this->adminRepository->update($adminId, [
            'password'  => Hash::make($request->password)
        ]);

        return new AdminResource($admin);
    }

    public function destroy($adminId)
    {
        $this->adminRepository->destroy($adminId);
    }

    public function getActivities($adminId, $request)
    {
        $limit = $request->get('limit', 20);
        $activities = app(ActivityService::class)->getAdminActivities($adminId, $limit);

        return new PaginateResource(ActivityResource::collection($activities));
    }
}
