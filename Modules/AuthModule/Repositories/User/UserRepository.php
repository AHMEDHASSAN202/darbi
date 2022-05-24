<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\AuthModule\Repositories\User;

use Illuminate\Http\Request;
use Modules\AuthModule\Entities\User;
use Modules\CommonModule\Traits\CrudRepositoryTrait;
use MongoDB\BSON\ObjectId;

class UserRepository
{
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function findByMobile($phone, $phoneCode, $with = [])
    {
        return $this->model->where('phone', $phone)->where('phone_code', $phoneCode)->with($with)->first();
    }

    public function createUserFromSignin($phone, $country)
    {
        return $this->model->create([
                'phone'         => $phone,
                'phone_code'    => $country->calling_code,
                'country_id'    => new ObjectId($country->_id),
                'is_active'     => true,
                'is_verified'   => true
            ]);
    }
}
