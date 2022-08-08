<?php

namespace Modules\CommonModule\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CommonModule\Services\HomeService;

class HomeController extends Controller
{
    private $homeService;

    public function __construct(HomeService $homeService)
    {
        $this->homeService = $homeService;
    }


    public function index(Request $request)
    {
        return view('commonmodule::home', $this->homeService->getHomeData($request));
    }
}
