<?php

namespace Modules\CommonModule\Http\Controllers\Web;

use Illuminate\Routing\Controller;

class PageController extends Controller
{
    public function about()
    {
        return view('commonmodule::pages.about');
    }

    public function contact()
    {
        return view('commonmodule::pages.contact');
    }

    public function policy()
    {
        return view('commonmodule::pages.policy');
    }
}
