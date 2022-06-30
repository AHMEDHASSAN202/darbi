<?php

namespace Modules\CatalogModule\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CatalogModule\Http\Requests\Admin\CreateYachtRequest;
use Modules\CatalogModule\Http\Requests\Admin\UpdateYachtRequest;
use Modules\CatalogModule\Services\Admin\YachtService;
use Modules\CommonModule\Traits\ApiResponseTrait;


class YachtController extends Controller
{
    use ApiResponseTrait;

    private $yachtService;

    public function __construct(YachtService $yachtService)
    {
        $this->yachtService = $yachtService;
    }

    public function index(Request $request)
    {
        $yachts = $this->yachtService->findAll($request);

        return $this->apiResponse(compact('yachts'));
    }

    public function show($id)
    {
        $yacht = $this->yachtService->find($id);

        return $this->apiResponse(compact('yacht'));
    }

    public function destroy($id)
    {
        $this->yachtService->deleteByAdmin($id);

        return $this->apiResponse([], 200, __('Data has been deleted successfully'));
    }
}
