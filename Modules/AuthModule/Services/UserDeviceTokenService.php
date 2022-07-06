<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\AuthModule\Services;

use Illuminate\Support\Facades\Log;
use Jenssegers\Mongodb\Eloquent\Model;
use Modules\AuthModule\Events\AfterUserLoginEvent;
use Modules\AuthModule\Http\Requests\StoreDeviceTokenRequest;
use Modules\AuthModule\Http\Requests\User\SendOtpRequest;
use Modules\AuthModule\Http\Requests\User\SigninRequest;
use Modules\AuthModule\Http\Requests\User\SigninWithOtpRequest;
use Modules\AuthModule\Jobs\SendOtpJob;
use Modules\AuthModule\Repositories\User\UserRepository;
use Modules\AuthModule\Repositories\UserDeviceTokenRepository;
use Modules\AuthModule\Transformers\UserProfileResource;
use Modules\CommonModule\Repositories\CountryRepository;
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

        return $this->handleDeviceToken($storeDeviceTokenRequest, 'user', $me);
    }


    private function handleDeviceToken(StoreDeviceTokenRequest $storeDeviceTokenRequest, $appType, $user = null)
    {
        $token = $this->deviceTokenRepository->findByPlatform($storeDeviceTokenRequest->phone_uuid, $storeDeviceTokenRequest->device_os);

        if (!$token) {
            $this->deviceTokenRepository->create([
                'phone_uuid'        => $storeDeviceTokenRequest->phone_uuid,
                'app_type'          => $appType,
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
}
