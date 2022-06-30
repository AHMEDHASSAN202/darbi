<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\BookingModule\Services\Admin;

use Illuminate\Http\Request;
use Modules\BookingModule\Repositories\BookingPaymentTransactionRepository;
use Modules\BookingModule\Transformers\Admin\BookingPaymentTransactionExportResource;
use Modules\BookingModule\Transformers\Admin\BookingPaymentTransactionResource;
use Modules\CommonModule\Transformers\PaginateResource;
use MongoDB\BSON\ObjectId;

class BookingPaymentTransactionService
{
    private $bookingPaymentTransactionRepository;


    public function __construct(BookingPaymentTransactionRepository $bookingPaymentTransactionRepository)
    {
        $this->bookingPaymentTransactionRepository = $bookingPaymentTransactionRepository;
    }

    public function findAllByVendor(Request $request, $vendorId = null)
    {
        $vendorId = new ObjectId(getVendorId());

        $transactions = $this->bookingPaymentTransactionRepository->findAllByVendor($request, $vendorId);

        return new PaginateResource(BookingPaymentTransactionResource::collection($transactions));
    }

    public function findAllByVendorForExport($vendorId)
    {
        try {
            $vendorId = new ObjectId($vendorId);
        }catch (\Exception $exception) {
            abort(404);
        }

        $transactions = $this->bookingPaymentTransactionRepository->findAllByVendorForExport($vendorId);

        return BookingPaymentTransactionExportResource::collection($transactions);
    }

    public function getCallbackExportTransaction(Request $request, $vendorId)
    {
        $transactions = $this->findAllByVendorForExport($vendorId)->collection->map->toArray($request);

        return exportData('transactions.csv', ['id' => 'ID', 'name' => 'Name', 'amount' => 'Amount', 'status' => 'Status', 'payment_method' => 'Payment method', 'created_at' => 'Created at'],  $transactions->toArray());
    }

    public function getExportUrl()
    {
        return route('vendor.transactions', getVendorId());
    }
}
