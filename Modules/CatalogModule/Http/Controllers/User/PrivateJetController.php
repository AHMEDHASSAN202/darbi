<?php

namespace Modules\CatalogModule\Http\Controllers\User;

use Illuminate\Routing\Controller;
use Modules\CatalogModule\Services\PrivateJetService;
use Modules\CommonModule\Traits\ApiResponseTrait;

class PrivateJetController extends Controller
{
    use ApiResponseTrait;

    private $privateJetService;

    public function __construct(PrivateJetService $privateJetService)
    {
        $this->privateJetService = $privateJetService;
    }

    public function index()
    {
        return $this->apiResponse([
            'info'      => $this->privateJetService->getInfo()
        ]);
    }
}
