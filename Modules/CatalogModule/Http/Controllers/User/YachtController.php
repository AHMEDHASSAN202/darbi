<?php

namespace Modules\CatalogModule\Http\Controllers\User;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CatalogModule\Http\Requests\ListOfEntitiesRequest;
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

    public function index(ListOfEntitiesRequest $entitiesRequest)
    {
        return $this->apiResponse([
            'yachts'    => $this->yachtService->findAll($entitiesRequest)
        ]);
    }

    public function show($yachtId)
    {
        return $this->apiResponse([
            'yacht'       => $this->yachtService->find($yachtId)
        ]);
    }
}
