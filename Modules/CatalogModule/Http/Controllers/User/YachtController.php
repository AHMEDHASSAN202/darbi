<?php

namespace Modules\CatalogModule\Http\Controllers\User;

use Illuminate\Routing\Controller;
use Modules\CatalogModule\Http\Requests\User\ListOfEntitiesRequest;
use Modules\CatalogModule\Services\YachtService;
use Modules\CommonModule\Traits\ApiResponseTrait;

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

    public function share($yachtId)
    {
        return $this->apiResponse([
            'shareLink' => $this->yachtService->getShareLink($yachtId)
        ]);
    }
}
