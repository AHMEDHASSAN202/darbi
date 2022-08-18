<?php

namespace Modules\CatalogModule\Http\Controllers\User;

use Illuminate\Routing\Controller;
use Modules\CatalogModule\Http\Requests\User\ListOfEntitiesRequest;
use Modules\CatalogModule\Services\VillaService;
use Modules\CommonModule\Traits\ApiResponseTrait;

class VillaController extends Controller
{
    use ApiResponseTrait;

    private $villaService;

    public function __construct(VillaService $villaService)
    {
        $this->villaService = $villaService;
    }

    public function index(ListOfEntitiesRequest $entitiesRequest)
    {
        return $this->apiResponse([
            'villas'    => $this->villaService->findAll($entitiesRequest)
        ]);
    }

    public function show($villaId)
    {
        return $this->apiResponse([
            'villa'       => $this->villaService->find($villaId)
        ]);
    }

    public function share($villaId)
    {
        return $this->apiResponse([
            'shareLink' => $this->villaService->getShareLink($villaId, 'villas')
        ]);
    }
}
