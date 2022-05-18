<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\AuthModule\Services;

use Illuminate\Http\Request;
use Modules\AuthModule\Http\Requests\User\CreateUserRequest;
use Modules\AuthModule\Http\Requests\User\UpdateUserRequest;
use Modules\AuthModule\Repositories\User\UserRepository;
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
        $users = $this->userRepository->listOfUsers($request->get('limit', 20));

        return new PaginateResource(UserResource::collection($users));
    }

    public function create(CreateUserRequest $createUserRequest)
    {
        $data = $createUserRequest->validated();

        if ($createUserRequest->hasFile('image')) {
            $data['image'] = $this->uploadAvatar($createUserRequest->file('image'));
        }

        return $this->userRepository->create($data);
    }

    public function update($id, UpdateUserRequest $updateUserRequest)
    {
        $data = $updateUserRequest->validated();

        if ($updateUserRequest->hasFile('image')) {
            $data['image'] = $this->uploadAvatar($updateUserRequest->file('image'));
        }

        return $this->userRepository->update($id, $data);
    }

    public function destroy($id)
    {
        return $this->userRepository->destroy($id);
    }
}
