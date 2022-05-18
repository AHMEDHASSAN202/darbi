<?php

namespace Modules\AuthModule\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\AuthModule\Http\Requests\User\CreateUserRequest;
use Modules\AuthModule\Http\Requests\User\UpdateUserRequest;
use Modules\AuthModule\Services\UserService;
use Modules\CommonModule\Traits\ApiResponseTrait;
use function __;

/**
 * @group Users
 *
 * Management users
 */
class UserController extends Controller
{
    use ApiResponseTrait;

    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * List of users
     *
     * @queryParam q string
     * get users. If everything is okay, you'll get a 200 OK response.
     * Otherwise, the request will fail with a 400 || 422 || 500 error
     */
    public function index(Request $request)
    {
        $users = $this->userService->findAll($request);

        return $this->apiResponse(compact('users'));
    }

    /**
     * Create User
     *
     * @bodyParam name string required
     * @bodyParam email string required
     * @bodyParam password string required
     * @bodyParam phone string required
     * @bodyParam image file optional.
     * @bodyParam country string optional. country code [2 chars]
     * @bodyParam city string optional. country code [2 chars]
     * create new user. If everything is okay, you'll get a 200 OK response.
     * Otherwise, the request will fail with a 400 || 422 || 500 error
     */
    public function store(CreateUserRequest $createUserRequest)
    {
        $user = $this->userService->create($createUserRequest);

        return $this->apiResponse(compact('user'), 201, __('Data has been added successfully'));
    }

    /**
     * Update User
     *
     * @param $id
     * @param UpdateUserRequest $updateUserRequest
     * @bodyParam name string required
     * @bodyParam email string required
     * @bodyParam password string required
     * @bodyParam phone string required
     * @bodyParam image file optional.
     * @bodyParam country string optional. country code [2 chars]
     * @bodyParam city string optional. country code [2 chars]
     * update user. If everything is okay, you'll get a 200 OK response.
     * Otherwise, the request will fail with a 400 || 422 || 500 error
     */
    public function update($id, UpdateUserRequest $updateUserRequest)
    {
        $user = $this->userService->update($id, $updateUserRequest);

        return $this->apiResponse(compact('user'), 200, __('Data has been updated successfully'));
    }

    /**
     * Delete User
     *
     * @param $id
     * delete vendor. If everything is okay, you'll get a 200 OK response.
     * Otherwise, the request will fail with a 400 || 422 || 500 error
     */
    public function destroy($id)
    {
        $this->userService->destroy($id);

        return $this->apiResponse([], 200, __('Data has been deleted successfully'));
    }
}
