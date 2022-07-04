<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\AuthModule\Repositories;

use Modules\AuthModule\Entities\UserDeviceToken;
use Modules\AuthModule\Http\Requests\StoreDeviceTokenRequest;

class UserDeviceTokenRepository
{
    private $model;


    public function __construct(UserDeviceToken $userDeviceToken)
    {
        $this->model = $userDeviceToken;
    }


    public function create($data)
    {
        return $this->model->create($data);
    }


    public function exists($phone_uuid, $platform)
    {
        return $this->model->where('phone_uuid', $phone_uuid)->where('device_os', $platform)->exists();
    }


    public function findByPlatform($phone_uuid, $platform)
    {
        return $this->model->where('phone_uuid', $phone_uuid)->where('device_os', $platform)->first();
    }
}
