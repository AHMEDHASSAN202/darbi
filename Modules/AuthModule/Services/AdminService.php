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
use Modules\CommonModule\Traits\ImageHelperTrait;
use Modules\CommonModule\Transformers\PaginateResource;
use MongoDB\BSON\ObjectId;

class AdminService
{
    use ImageHelperTrait;

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

    public function find($adminId)
    {
        $admin = $this->adminRepository->find($adminId);

        return new AdminResource($admin);
    }

    public function create($request)
    {
        $data = [
            'name'      => $request->name,
            'email'     => $request->email,
            'role_id'   => new ObjectId($request->role_id),
            'password'  => Hash::make($request->password),
            'type'      => $request->type
        ];

        if ($request->type == 'vendor' && $request->vendor_id) {
            $data['vendor_id'] = new ObjectId($request->vendor_id);
        }

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadImage('avatars', $request->image);
        }

        $admin = $this->adminRepository->create($data);

        return [
            'id'    => $admin->id
        ];
    }

    public function update($adminId, $request)
    {
        $admin = $this->adminRepository->find($adminId, []);

        $data = [
            'name'      => $request->name,
            'email'     => $request->email,
            'role_id'   => new ObjectId($request->role_id),
            'type'      => $request->type
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->type == 'vendor' && $request->vendor_id) {
            $data['vendor_id'] = new ObjectId($request->vendor_id);
        }

        $oldImage = null;
        if ($request->hasFile('image')) {
            $oldImage = $admin->image;
            $data['image'] = $this->uploadImage('avatars', $request->image);
        }

        $admin->update($data);

        $this->_removeImage($oldImage);

        return [
            'id'    => $adminId
        ];
    }

    public function updatePassword($adminId, $request)
    {
        $admin = $this->adminRepository->update($adminId, [
            'password'  => Hash::make($request->password)
        ]);

        return [
            'id'        => $adminId
        ];
    }

    public function destroy($adminId)
    {
        if (auth('admin_api')->id() == $adminId) {
            return [
                'message'    => __('action not allowed'),
                'statusCode' => 400,
                'errors'     => []
            ];
        }

        $this->adminRepository->destroy($adminId);

        return [
            'message'    => __('Data has been deleted successfully'),
            'statusCode' => 200,
            'errors'     => []
        ];
    }

    public function getActivities($adminId, $request)
    {
        $limit = $request->get('limit', 20);
        $activities = app(ActivityService::class)->getAdminActivities($adminId, $limit);

        return new PaginateResource(ActivityResource::collection($activities));
    }

    public function getVendorAdminToken($vendorId)
    {
        $admin = $this->adminRepository->getVendorAdmin($vendorId);

        if (!$admin) {
            return [
                'statusCode'    => 400,
                'data'          => [],
                'message'       => __('admin not exists')
            ];
        }

        $token = auth('vendor_api')->login($admin);

        return [
            'statusCode'    => 200,
            'data'          => [
                'token'    => $token
            ],
            'message'       => ''
        ];
    }
}
