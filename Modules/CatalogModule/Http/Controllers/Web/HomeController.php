<?php

namespace Modules\CatalogModule\Http\Controllers\Web;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CatalogModule\Services\HomeService;

class HomeController extends Controller
{
    private $homeService;

    public function __construct(HomeService $homeService)
    {
        $this->homeService = $homeService;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        app()->setLocale(__get_lang());

        return view('catalogmodule::home', $this->homeService->getHomeData($request));
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function about(Request $request)
    {
        app()->setLocale(__get_lang());

        return view('catalogmodule::pages.about');
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function contact(Request $request)
    {
        app()->setLocale(__get_lang());

        return view('catalogmodule::pages.contact');
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function policy(Request $request)
    {
        app()->setLocale(__get_lang());

        return view('catalogmodule::pages.policy');
    }
}
