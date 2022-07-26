<?php

namespace Modules\CatalogModule\Http\Controllers\Internal;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CatalogModule\Http\Requests\Admin\CreateBranchRequest;
use Modules\CatalogModule\Http\Requests\Admin\UpdateBranchRequest;
use Modules\CatalogModule\Services\Admin\BranchService;
use Modules\CommonModule\Traits\ApiResponseTrait;

class BranchController extends Controller
{
    use ApiResponseTrait;

    private $branchService;


    public function __construct(BranchService $branchService)
    {
        $this->branchService = $branchService;
    }


    public function show($branchId)
    {
        $branch = $this->branchService->find($branchId);

        return $this->apiResponse(compact('branch'));
    }
}
