<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\AuthModule\Services;

use Illuminate\Http\Request;
use Modules\AuthModule\Http\Requests\StoreDeviceTokenRequest;
use Modules\AuthModule\Repositories\UserDeviceTokenRepository;
use MongoDB\BSON\ObjectId;

class UserDeviceTokenService
{
    private $deviceTokenRepository;

    public function __construct(UserDeviceTokenRepository $deviceTokenRepository)
    {
        $this->deviceTokenRepository = $deviceTokenRepository;
    }


    public function handleUserDeviceToken(StoreDeviceTokenRequest $storeDeviceTokenRequest)
    {
        $me = app(UserAuthService::class)->authUser();

        $this->handleDeviceToken($storeDeviceTokenRequest, $me);

        return successResponse([], __('Token Saved'));
    }


    public function handleAdminDeviceToken(StoreDeviceTokenRequest $storeDeviceTokenRequest)
    {
        $me = auth(getCurrentGuard())->user();

        if (!$me) {
            return badResponse();
        }

        $this->handleDeviceToken($storeDeviceTokenRequest, $me);

        return successResponse([], __('Token Saved'));
    }


    private function handleDeviceToken(StoreDeviceTokenRequest $storeDeviceTokenRequest, $user = null)
    {
        $token = $this->deviceTokenRepository->findByPlatform($storeDeviceTokenRequest->phone_uuid, $storeDeviceTokenRequest->device_os);

        if (!$token) {
            $this->deviceTokenRepository->create([
                'phone_uuid'        => $storeDeviceTokenRequest->phone_uuid,
                'device_os'         => $storeDeviceTokenRequest->device_os,
                'lat'               => $storeDeviceTokenRequest->lat ? (float)$storeDeviceTokenRequest->lat : null,
                'lng'               => $storeDeviceTokenRequest->lng ? (float)$storeDeviceTokenRequest->lng : null,
                'user_details'      => $user ? [
                    'id'                => new ObjectId($user->_id),
                    'on_model'          => get_class($user)
                ] : []
            ]);

        }else {
            //update token with current user
            if (empty($token->user_details) && $user) {
                $token->update([
                    'user_details'      => [
                        'id'                => new ObjectId($user->_id),
                        'on_model'          => get_class($user)
                    ]
                ]);
            }
        }
    }


    public function findAll(Request $request)
    {
        $request->validate(['receivers' => 'required_if:type,specified']);

        try {
            $players = $this->deviceTokenRepository->findAll($request);

            return serviceResponse(['players' => $players]);

        }catch (\Exception $exception) {
            helperLog(__CLASS__, __FUNCTION__, $exception->getMessage());
            return serviceResponse([], 500, __('Unable get data'));
        }
    }
}
