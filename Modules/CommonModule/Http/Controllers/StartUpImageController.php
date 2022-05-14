<?php

namespace Modules\CommonModule\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CommonModule\Services\CommonService;
use Modules\CommonModule\Traits\ApiResponseTrait;

class StartUpImageController extends Controller
{
    use ApiResponseTrait;

    private $commonService;

    public function __construct(CommonService $commonService)
    {
        $this->commonService = $commonService;
    }

    public function index(Request $request)
    {
        return $this->apiResponse([
            'startUpImages' => $this->commonService->getStartUpImages($request)
        ]);
    }
}
