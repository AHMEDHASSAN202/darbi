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
            return successResponse(['users' => new PaginateResource(UserResource::collection($users))]);
        }

        return successResponse(['users' => UserResource::collection($users)]);
    }

    public function find($userId)
    {
        $user = $this->userRepository->find($userId, ['savedPlaces', 'lastBooking']);

        return successResponse(['user' => new FindUserResource($user)]);
    }

    public function destroy($userId)
    {
        $this->userRepository->destroy($userId);

        return deletedResponse();
    }

    public function toggleActive($userId)
    {
        $this->userRepository->toggleActive($userId);

        return updatedResponse(['id' => $userId]);
    }

    public function findAllIds(Request $request)
    {
        $userIds = $this->userRepository->findAllIds($request);

        if ($userIds instanceof LengthAwarePaginator) {
            return successResponse(['users' => new PaginateResource(UserIdResource::collection($userIds))]);
        }

        return successResponse(['users' => UserIdResource::collection($userIds)]);
    }
}
