<?php

namespace Modules\CatalogModule\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CatalogModule\Services\PortService;
use Modules\CommonModule\Traits\ApiResponseTrait;

class PortController extends Controller
{
    use ApiResponseTrait;

    private $portService;

    public function __construct(PortService $portService)
    {
        $this->portService = $portService;
    }

    public function index(Request $request)
    {
        return $this->apiResponse([
            'ports'    => $this->portService->findAll($request)
        ]);
    }
}
