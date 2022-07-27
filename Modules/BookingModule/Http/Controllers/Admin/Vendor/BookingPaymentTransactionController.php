<?php

namespace Modules\BookingModule\Http\Controllers\Admin\Vendor;

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
        $transactions = $this->paymentTransactionService->findAllByVendor($request);
        $exportUrl = $this->paymentTransactionService->getExportUrl();

        return $this->apiResponse(compact('transactions', 'exportUrl'));
    }


    public function export(Request $request, $vendorId)
    {
        return $this->paymentTransactionService->getCallbackExportTransaction($request, $vendorId);
    }
}
