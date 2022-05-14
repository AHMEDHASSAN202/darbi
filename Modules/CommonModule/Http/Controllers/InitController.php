<?php

namespace Modules\CommonModule\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CommonModule\Traits\ApiResponseTrait;

class InitController extends Controller
{
    use ApiResponseTrait;


    public function index()
    {
        return $this->apiResponse([
            //return global data
        ]);
    }
}
