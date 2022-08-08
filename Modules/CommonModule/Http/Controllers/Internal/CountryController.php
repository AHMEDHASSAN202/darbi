<?php

namespace Modules\CommonModule\Http\Controllers\Internal;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CommonModule\Http\Requests\AddBranchToRegionsRequest;
use Modules\CommonModule\Http\Requests\RemoveBranchFromRegionsRequest;
use Modules\CommonModule\Services\Admin\CountryService;
use Modules\CommonModule\Services\RegionService;
use Modules\CommonModule\Traits\ApiResponseTrait;


class CountryController extends Controller
{
    use ApiResponseTrait;

    private $countryService;

    public function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
    }

    public function find($countryId)
    {
        $result = $this->countryService->find($countryId);

        return $this->apiResponse(...$result);
    }
}
