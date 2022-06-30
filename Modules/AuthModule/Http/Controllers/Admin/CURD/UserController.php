<?php

namespace Modules\AuthModule\Http\Controllers\Admin\CURD;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\AuthModule\Services\UserService;
use Modules\CommonModule\Traits\ApiResponseTrait;


class UserController extends Controller
{
    use ApiResponseTrait;

    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }


    public function index(Request $request)
    {
        $users = $this->userService->findAll($request);

        return $this->apiResponse(compact('users'));
    }


    public function show($userId)
    {
        $user = $this->userService->find($userId);

        return $this->apiResponse(compact('user'));
    }


    public function destroy($userId)
    {
        $this->userService->destroy($userId);

        return $this->apiResponse([], 200, __('Data has been deleted successfully'));
    }


    public function toggleActive($userId)
    {
        $result = $this->userService->toggleActive($userId);

        return $this->apiResponse($result, 200, __('Data has been updated successfully'));
    }
}
