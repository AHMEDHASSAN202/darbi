<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\BookingModule\Services\Admin;

use Illuminate\Http\Request;
use Modules\BookingModule\Repositories\BookingPaymentTransactionRepository;
use Modules\BookingModule\Transformers\Admin\AdminBookingPaymentTransactionExportResource;
use Modules\BookingModule\Transformers\Admin\AdminBookingPaymentTransactionResource;
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

    public function findAllByVendor(Request $request)
    {
        $vendorId = new ObjectId(getVendorId());

        $transactions = $this->bookingPaymentTransactionRepository->findAllByVendor($request, $vendorId);

        return new PaginateResource(BookingPaymentTransactionResource::collection($transactions));
    }

    public function findAllByVendorForExport($vendorId)
    {
        $transactions = $this->bookingPaymentTransactionRepository->findAllByVendorForExport(new ObjectId($vendorId));

        return BookingPaymentTransactionExportResource::collection($transactions);
    }

    public function getCallbackExportTransaction(Request $request, $vendorId)
    {
        $transactions = $this->findAllByVendorForExport($vendorId)->collection->map->toArray($request);

        return exportData('transactions.csv', ['id' => 'ID', 'name' => 'Name', 'amount' => 'Amount', 'status' => 'Status', 'payment_method' => 'Payment method', 'created_at' => 'Created at'],  $transactions->toArray());
    }

    public function getExportUrl($adminUrl=false)
    {
        if ($adminUrl) {
            return route('admin.transactions.export');
        }
        return route('vendor.transactions.export', getVendorId());
    }

    public function findAll(Request $request)
    {
        $transactions = $this->bookingPaymentTransactionRepository->findAll($request);

        return new PaginateResource(AdminBookingPaymentTransactionResource::collection($transactions));
    }

    public function getAdminCallbackExportTransaction(Request $request)
    {
        $transactions = $this->bookingPaymentTransactionRepository->findAllForExport($request);
        $transactions = AdminBookingPaymentTransactionExportResource::collection($transactions);

        return exportData('transactions.csv', ['id' => 'ID', 'vendor_name' => 'Vendor', 'name' => 'Name', 'amount' => 'Amount', 'status' => 'Status', 'payment_method' => 'Payment method', 'created_at' => 'Created at'],  $transactions->toArray($request));
    }
}
