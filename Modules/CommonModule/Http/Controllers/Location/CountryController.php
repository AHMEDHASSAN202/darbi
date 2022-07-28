<?php

namespace Modules\CommonModule\Http\Controllers\Location;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CommonModule\Services\CountryService;
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
        $result = $this->countryService->countries($request);

        return $this->apiResponse(...$result);
    }
}
