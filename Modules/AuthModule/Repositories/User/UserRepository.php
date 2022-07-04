<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\AuthModule\Repositories\User;

use Illuminate\Http\Request;
use Modules\AuthModule\Entities\User;

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

    public function createUserFromSignin($phone, $phoneCode)
    {
        return $this->model->create([
            'phone' => $phone,
            'phone_code' => $phoneCode,
            'is_active' => true,
            'verification_code' => generateOTPCode()
        ]);
    }

    public function findAll(Request $request)
    {
        return $this->model->with('lastBooking')->search($request)->filter($request)->latest()->paginate($request->get('limit', 20));
    }

    public function find($userId, $with = [])
    {
        return $this->model->with($with)->findOrFail($userId);
    }

    public function destroy($userId)
    {
        return $this->model->destroy($userId);
    }

    public function toggleActive($userId)
    {
        $user = $this->model->findOrFail($userId);
        $user->is_active = !$user->is_active;
        $user->save();

        return $user;
    }
}
