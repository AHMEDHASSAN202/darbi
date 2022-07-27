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
        $result = $this->userService->findAll($request);

        return $this->apiResponse(...$result);
    }


    public function show($userId)
    {
        $result = $this->userService->find($userId);

        return $this->apiResponse(...$result);
    }


    public function destroy($userId)
    {
        $result = $this->userService->destroy($userId);

        return $this->apiResponse(...$result);
    }


    public function toggleActive($userId)
    {
        $result = $this->userService->toggleActive($userId);

        return $this->apiResponse(...$result);
    }
}
