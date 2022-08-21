<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\AuthModule\Repositories\User;

use Illuminate\Http\Request;
use Modules\AuthModule\Entities\User;
use MongoDB\BSON\ObjectId;

class UserRepository
{
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function findByMobile($phone, $phoneCode, $with = [])
    {
        return $this->model->where('phone', $phone)->where('phone_code', phoneCodeCleaning($phoneCode))->with($with)->first();
    }

    public function createUserFromSignin($phone, $phoneCode)
    {
        return $this->model->create([
            'phone' => $phone,
            'phone_code' => phoneCodeCleaning($phoneCode),
            'is_active' => true,
            'verification_code' => generateOTPCode()
        ]);
    }

    public function findAll(Request $request)
    {
        return $this->model->with('lastBooking')->search($request)->filter($request)->latest()->paginated();
    }

    public function findAllIds(Request $request)
    {
        return $this->model->search($request)->filter($request)->latest()->paginated();
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

    public function findAllByPhones($phones)
    {
        $users = $this->model->raw(function ($collection) use ($phones) {
            return $collection->aggregate([
                [
                    '$project'  => [
                        "phoneWithCode" => ['$concat'       => ['$phone_code', '$phone']]
                    ]
                ],
                [
                    '$match'        => [
                        'phoneWithCode'          => [ '$in' => (array)$phones ],
                    ]
                ]
            ]);
        });

        if (!$users->count()) {
            return [];
        }

        return $users;
    }
}
