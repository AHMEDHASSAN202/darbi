<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\AuthModule\Servcies;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Modules\AuthModule\Repositories\AuthAdminRepository;
use Modules\AuthModule\Transformers\AuthAdminResource;

class AuthAdminService
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
            $response['message'] = __('authmodule::auth.admin not found');
        }

        try {
            $response['data'] = [
                'token'     => auth($this->guardName)->login($me),
                'profile'   => new AuthAdminResource($me)
            ];
        }catch (\Exception $exception) {
            $response['data'] = [];
            $response['statusCode'] = 500;
            $response['message'] = null;
        }

        return $response;
    }
}
