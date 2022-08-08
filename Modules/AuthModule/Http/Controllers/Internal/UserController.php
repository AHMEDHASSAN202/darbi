<?php

namespace Modules\AuthModule\Http\Controllers\Internal;

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

    public function findAllIds(Request $request)
    {
        $result = $this->userService->findAllIds($request);

        return $this->apiResponse(...$result);
    }
}
