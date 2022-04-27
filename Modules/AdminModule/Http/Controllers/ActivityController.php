<?php

namespace Modules\AdminModule\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\AdminModule\Services\AdminService;
use Modules\CommonModule\Traits\ApiResponseTrait;

class ActivityController extends Controller
{
    use ApiResponseTrait;

    private $adminService;


    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function show($adminId, Request $request)
    {
        $activities = $this->adminService->getActivities($adminId, $request);

        return $this->apiResponse(compact('activities'));
    }
}
