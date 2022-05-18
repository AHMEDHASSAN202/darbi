<?php

namespace Modules\CommonModule\Http\Controllers;


use Illuminate\Routing\Controller;
use Modules\CommonModule\Http\Requests\InitRequest;
use Modules\CommonModule\Services\InitService;
use Modules\CommonModule\Traits\ApiResponseTrait;

class InitController extends Controller
{
    use ApiResponseTrait;

    public function index(InitRequest $initRequest, InitService $initService)
    {
        //return global data
        return $this->apiResponse($initService->initData($initRequest));
    }
}
