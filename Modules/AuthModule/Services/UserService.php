<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\AuthModule\Services;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\AuthModule\Repositories\User\UserRepository;
use Modules\AuthModule\Transformers\FindUserResource;
use Modules\AuthModule\Transformers\UserIdResource;
use Modules\AuthModule\Transformers\UserResource;
use Modules\CommonModule\Traits\ImageHelperTrait;
use Modules\CommonModule\Transformers\PaginateResource;

class UserService
{
    use ImageHelperTrait;

    private $userRepository;


    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function findAll(Request $request)
    {
        $users = $this->userRepository->findAll($request);

        if ($users instanceof LengthAwarePaginator) {
            return new PaginateResource(UserResource::collection($users));
        }

        return UserResource::collection($users);
    }

    public function find($userId)
    {
        $user = $this->userRepository->find($userId, ['savedPlaces', 'lastBooking']);

        return new FindUserResource($user);
    }

    public function destroy($userId)
    {
        return $this->userRepository->destroy($userId);
    }

    public function toggleActive($userId)
    {
        $this->userRepository->toggleActive($userId);

        return [
            'id'    => $userId
        ];
    }

    public function findAllIds(Request $request)
    {
        $userIds = $this->userRepository->findAllIds($request);

        if ($userIds instanceof LengthAwarePaginator) {
            return new PaginateResource(UserIdResource::collection($userIds));
        }

        return UserIdResource::collection($userIds);
    }
}
