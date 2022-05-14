<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\UserModule\Services;

use Illuminate\Http\Request;
use Modules\CommonModule\Traits\ImageHelperTrait;
use Modules\CommonModule\Transformers\PaginateResource;
use Modules\UserModule\Repositories\UserRepository;
use Modules\UserModule\Transformers\UserResource;
use Modules\UserModule\Http\Requests\CreateUserRequest;
use Modules\UserModule\Http\Requests\UpdateUserRequest;

class UserService
{
    use ImageHelperTrait;

    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function list(Request $request)
    {
        $limit = $request->get('limit', 20);
        $users = $this->userRepository->listOfUsers($limit);

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
