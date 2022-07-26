<?php

namespace Modules\CatalogModule\Http\Controllers\Internal;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CatalogModule\Http\Requests\Admin\CreatePortRequest;
use Modules\CatalogModule\Http\Requests\Admin\UpdatePortRequest;
use Modules\CatalogModule\Services\Admin\PortService;
use Modules\CommonModule\Traits\ApiResponseTrait;

class PortController extends Controller
{
    use ApiResponseTrait;

    private $portService;

    public function __construct(PortService $portService)
    {
        $this->portService = $portService;
    }

    public function show($portId)
    {
        return $this->apiResponse([
            'port'      => $this->portService->find($portId)
        ]);
    }
}
