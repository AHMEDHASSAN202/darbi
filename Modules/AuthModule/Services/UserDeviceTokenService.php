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

        return $this->storeDeviceToken($storeDeviceTokenRequest, 'user', $me, $me->country_id);
    }


    private function storeDeviceToken(StoreDeviceTokenRequest $storeDeviceTokenRequest, $appType, Model $user, $countryId)
    {
        $exists = $this->deviceTokenRepository->exists($storeDeviceTokenRequest->phone_uuid, $storeDeviceTokenRequest->device_os);

        if (!$exists) {
            $this->deviceTokenRepository->create([
                'phone_uuid'        => $storeDeviceTokenRequest->phone_uuid,
                'app_type'          => $appType,
                'country_id'        => $countryId,
                'device_os'         => $storeDeviceTokenRequest->device_os,
                'lat'               => $storeDeviceTokenRequest->lat,
                'lng'               => $storeDeviceTokenRequest->lng,
                'region_id'         => new ObjectId($storeDeviceTokenRequest->region_id),
                'user_details'      => [
                    'id'                => new ObjectId($user->_id),
                    'on_model'          => get_class($user)
                ]
            ]);
        }

        return null;
    }
}
