<?php

namespace Modules\CommonModule\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CommonModule\Services\Admin\CountryService;
use Modules\CommonModule\Traits\ApiResponseTrait;

class CountryController extends Controller
{
    use ApiResponseTrait;

    private $countryService;

    public function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
    }

    public function index(Request $request)
    {
        $result = $this->countryService->findAll($request);

        return $this->apiResponse(...$result);
    }

    public function toggleActive($countryId)
    {
        $result = $this->countryService->toggleActive($countryId);

        return $this->apiResponse(...$result);
    }
}
