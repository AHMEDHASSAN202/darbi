<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\BookingModule\Repositories;

use Illuminate\Http\Request;
use Modules\BookingModule\Entities\BookingPaymentTransaction;
use MongoDB\BSON\ObjectId;

class BookingPaymentTransactionRepository
{
    private $bookingPaymentTransaction;


    public function __construct(BookingPaymentTransaction $bookingPaymentTransaction)
    {
        $this->bookingPaymentTransaction = $bookingPaymentTransaction;
    }

    public function findAllByVendor(Request $request, ObjectId $vendorId)
    {
        return $this->bookingPaymentTransaction->latest()->where('vendor_id', $vendorId)->adminSearch($request)->adminFilter($request)->paginate($request->get('limit', 20));
    }

    public function findAll($request)
    {
        return $this->bookingPaymentTransaction->latest()->adminSearch($request)->adminFilter($request)->with('vendor')->paginate($request->get('limit', 20));
    }

    public function findAllByVendorForExport(ObjectId $vendorId)
    {
        return $this->bookingPaymentTransaction->latest()->where('vendor_id', $vendorId)->get();
    }

    public function findAllForExport($request)
    {
        return $this->bookingPaymentTransaction->latest()->adminSearch($request)->with('vendor')->adminFilter($request)->get();
    }
}
