<?php

namespace Modules\CatalogModule\Http\Controllers\Web;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CatalogModule\Services\EntityService;

class ShareController extends Controller
{
    private $entityService;

    public function __construct(EntityService $entityService)
    {
        $this->entityService = $entityService;
    }

    public function __invoke($entityType, $id)
    {
        $entity = $this->entityService->find($id);

        return view('catalogmodule::pages.share', [
            'entity'        => $entity->resource
        ]);
    }
}
