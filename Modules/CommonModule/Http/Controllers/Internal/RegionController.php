<?php

namespace Modules\CommonModule\Http\Controllers\Internal;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CommonModule\Http\Requests\AddBranchToRegionsRequest;
use Modules\CommonModule\Http\Requests\RemoveBranchFromRegionsRequest;
use Modules\CommonModule\Services\RegionService;
use Modules\CommonModule\Traits\ApiResponseTrait;


class RegionController extends Controller
{
    use ApiResponseTrait;

    private $regionService;

    public function __construct(RegionService $regionService)
    {
        $this->regionService = $regionService;
    }

    public function index(Request $request)
    {
        $result = $this->regionService->regions($request);

        return $this->apiResponse(...$result);
    }

    public function addBranchToRegions(AddBranchToRegionsRequest $addBranchToRegionsRequest)
    {
        $result = $this->regionService->addBranchToRegions($addBranchToRegionsRequest);

        return $this->apiResponse(...$result);
    }

    public function removeBranchFromRegions(RemoveBranchFromRegionsRequest $removeBranchFromRegionsRequest)
    {
        $result = $this->regionService->removeBranchFromRegions($removeBranchFromRegionsRequest);

        return $this->apiResponse(...$result);
    }
}
