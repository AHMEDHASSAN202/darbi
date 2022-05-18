<?php

namespace Modules\CatalogModule\Http\Controllers\User;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CatalogModule\Services\YachtService;
use Modules\CommonModule\Traits\ApiResponseTrait;
use function view;

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
        return $this->apiResponse([
            'yachts'    => $this->yachtService->findAll($request)
        ]);
    }

    public function show($yachtId)
    {
        return $this->apiResponse([
            'car'       => $this->yachtService->find($yachtId)
        ]);
    }
}
