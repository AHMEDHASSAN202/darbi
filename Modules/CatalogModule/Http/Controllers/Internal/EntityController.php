<?php

namespace Modules\CatalogModule\Http\Controllers\Internal;

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

    public function updateState($entityId, $state)
    {
        $result = $this->entityService->updateState($entityId, $state);

        return $this->apiResponse(...$result);
    }
}
