<?php

namespace Modules\BookingModule\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\BookingModule\Services\Admin\BookingPaymentTransactionService;
use Modules\CommonModule\Traits\ApiResponseTrait;

class BookingPaymentTransactionController extends Controller
{
    use ApiResponseTrait;

    private $paymentTransactionService;


    public function __construct(BookingPaymentTransactionService $paymentTransactionService)
    {
        $this->paymentTransactionService = $paymentTransactionService;
    }


    public function index(Request $request)
    {
        $transactions = $this->paymentTransactionService->findAll($request);
        $exportUrl = $this->paymentTransactionService->getExportUrl(true);

        return $this->apiResponse(compact('transactions', 'exportUrl'));
    }


    public function export(Request $request)
    {
        return $this->paymentTransactionService->getAdminCallbackExportTransaction($request);
    }
}
