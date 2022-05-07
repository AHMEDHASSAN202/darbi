<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\AuthModule\Servcies;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Modules\AuthModule\Repositories\AuthVendorRepository;
use Modules\ProfileModule\Transformers\VendorProfileResource;

class AuthVendorService
{
    private $authVendorRepository;

    private $guardName = 'vendor_api';


    public function __construct(AuthVendorRepository $authVendorRepository)
    {
        $this->authVendorRepository = $authVendorRepository;
    }

    public function login(Request $request)
    {
        $response['data'] = [];
        $response['statusCode'] = 200;
        $response['message'] = null;
        $response['errors'] = [];

        $me = $this->authVendorRepository->find($request->email);

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
                'profile'   => new VendorProfileResource($me)
            ];
        }catch (\Exception $exception) {
            $response['data'] = [];
            $response['statusCode'] = 500;
            $response['message'] = null;
        }

        return $response;
    }
}
