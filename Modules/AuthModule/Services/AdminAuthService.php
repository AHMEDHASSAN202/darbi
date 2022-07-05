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
        $response['data'] = [];
        $response['statusCode'] = 200;
        $response['message'] = null;
        $response['errors'] = [];

        $me = $this->adminRepository->findByEmail($request->email, $type, ['vendor']);

        if (
            !$me || !Hash::check($request->password, $me->password)
        ) {
            $response['statusCode'] = 400;
            //TODO: don't add any hard coded messages to the service... just add constant file with all message resource
            $response['message'] = __('Your email or password is incorrect. try again');
            return $response;
        }

        if ($type != 'admin' && (!$me->vendor || $me->vendor->isNotActive())) {
            $response['data'] = [];
            $response['statusCode'] = 500;
            $response['message'] = __('The vendor is not active, please contact support');
            return $response;
        }

        try {
            $response['data'] = [
                'token'     => auth($me->role->guard)->login($me),
                'profile'   => new AdminProfileResource($me)
            ];
        }catch (\Exception $exception) {
            //add to the log a tag message to show where the error happen "class name -> method_name -> operation desc -> error message"
            Log::error($exception->getMessage());
            //TODO: add response message builder as mention before to handle error response
            $response['data'] = [];
            $response['statusCode'] = 500;
            $response['message'] = null;
        }

        return $response;
    }
}
