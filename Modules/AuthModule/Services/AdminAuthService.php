<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\AuthModule\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Modules\AuthModule\Repositories\Admin\AdminRepository;
use Modules\AuthModule\Repositories\Admin\AuthVendorRepository;
use Modules\AuthModule\Transformers\AdminProfileResource;

class AdminAuthService
{
    private $adminRepository;

    public function __construct(AdminRepository $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    public function login(Request $request, $type)
    {
        $me = $this->adminRepository->findByEmail($request->email, $type, ['vendor']);

        if (
            !$me || !Hash::check($request->password, $me->password)
        ) {
            return badResponse([], __('Your email or password is incorrect. try again'));
        }

        if ($type != 'admin' && (!$me->vendor || $me->vendor->isNotActive())) {
            return badResponse([], __('The vendor is not active, please contact support'));
        }

        try {

            return successResponse([
                'token'     => auth($me->role->guard)->login($me),
                'profile'   => new AdminProfileResource($me)
            ]);

        }catch (\Exception $exception) {
            helperLog(__CLASS__, __FUNCTION__, $exception->getMessage());
            return serverErrorResponse();
        }
    }
}
