<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\AdminModule\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Modules\AdminModule\Repositories\AdminRepository;
use Modules\AdminModule\Transformers\AdminResource;
use Modules\AdminModule\Transformers\RoleCollection;
use Modules\CommonModule\Transformers\PaginateResource;

class AdminService
{
    private $adminRepository;

    public function __construct(AdminRepository $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    public function list(Request $request)
    {
        $limit = $request->get('limit', 20);
        $admins = $this->adminRepository->list($limit, 'adminSearch');

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
}
