<?php

namespace Modules\CatalogModule\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CatalogModule\Services\EntityService;
use Modules\CommonModule\Traits\ApiResponseTrait;

class EntityController extends Controller
{
    use ApiResponseTrait;

    private $entityService;

    public function __construct(EntityService $entityService)
    {
        $this->entityService = $entityService;
    }

    public function show($entityId)
    {
        return $this->apiResponse([
            'entity'       => $this->entityService->find($entityId)
        ]);
    }

    public function changeState($entityId, $state)
    {
        $result = $this->entityService->changeState($entityId, $state);

        return $this->apiResponse($result['data'], $result['statusCode'], $result['message']);
    }
}
