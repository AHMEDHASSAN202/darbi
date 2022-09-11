<?php

namespace Modules\CommonModule\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CommonModule\Services\CurrencyService;
use Modules\CommonModule\Traits\ApiResponseTrait;

class CurrencyController extends Controller
{
    use ApiResponseTrait;

    private $currencyService;

    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    public function __invoke()
    {
        return $this->apiResponse(['currencies' => $this->currencyService->getCurrenciesCode()]);
    }
}
