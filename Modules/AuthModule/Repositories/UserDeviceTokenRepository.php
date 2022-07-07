<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\AuthModule\Repositories;

use Illuminate\Http\Request;
use Modules\AuthModule\Entities\UserDeviceToken;

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


    public function findAll(Request $request)
    {
        return $this->model->filters($request)->get();
    }
}
