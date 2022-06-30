<?php

namespace Modules\CatalogModule\Http\Controllers\User;

use Illuminate\Routing\Controller;
use Modules\CatalogModule\Services\VendorService;
use Modules\CommonModule\Traits\ApiResponseTrait;

class VendorController extends Controller
{
    use ApiResponseTrait;

    private $vendorService;

    public function __construct(VendorService $vendorService)
    {
        $this->vendorService = $vendorService;
    }

    public function show($vendorId)
    {
        return $this->apiResponse([
            'vendor'    => $this->vendorService->findOne($vendorId)
        ]);
    }
}
