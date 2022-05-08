<?php

namespace Modules\CommonModule\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CommonModule\Services\CommonService;
use Modules\CommonModule\Traits\ApiResponseTrait;

class CountryController extends Controller
{
    use ApiResponseTrait;


    private $commonService;

    public function __construct(CommonService $commonService)
    {
        $this->commonService = $commonService;
    }

    public function index()
    {
        $countries = $this->commonService->countries();

        return $this->apiResponse(compact('countries'));
    }

    public function show($iso)
    {
        $country = $this->commonService->country($iso);

        return $this->apiResponse(compact('country'));
    }
}
