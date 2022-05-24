<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\AuthModule\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Modules\AuthModule\Repositories\Admin\AuthAdminRepository;
use Modules\AuthModule\Transformers\AdminProfileResource;

class AdminAuthService
{
    private $authAdminRepository;

    private $guardName = 'admin_api';


    public function __construct(AuthAdminRepository $authAdminRepository)
    {
        $this->authAdminRepository = $authAdminRepository;
    }

    public function login(Request $request)
    {
        $response['data'] = [];
        $response['statusCode'] = 200;
        $response['message'] = null;
        $response['errors'] = [];

        $me = $this->authAdminRepository->find($request->email);

        if (
            !$me || !Hash::check($request->password, $me->password)
        ) {
            $response['statusCode'] = 401;
            $response['message'] = __('Your email or password is incorrect. try again');
            return $response;
        }

        try {
            $response['data'] = [
                'token'     => auth($this->guardName)->login($me),
                'profile'   => new AdminProfileResource($me)
            ];
        }catch (\Exception $exception) {
            $response['data'] = [];
            $response['statusCode'] = 500;
            $response['message'] = null;
        }

        return $response;
    }
}
