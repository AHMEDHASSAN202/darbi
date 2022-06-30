<?php

namespace Modules\BookingModule\Entities;

use App\Eloquent\Base;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Modules\CatalogModule\Entities\Vendor;
use MongoDB\BSON\ObjectId;

class BookingPaymentTransaction extends Base
{
    use HasFactory;

    protected $guarded = [];

    protected static function newFactory()
    {
        return \Modules\BookingModule\Database\factories\BookingPaymentTransactionFactory::new();
    }


    //===================== scopes ====================\\

    public function scopeAdminSearch($query, Request $request)
    {
        if ($q = $request->get('q')) {
            $query->where(function ($query) use ($q) {
                $query->where('name.ar', 'LIKE', '%'.$q.'%')->orWhere('name.en', 'LIKE', '%'.$q.'%');
            });
        }
    }


    public function scopeAdminFilter($query, Request $request)
    {
        if ($vendorId = $request->get('vendor')) {
            $query->where('vendor_id', new ObjectId($vendorId));
        }

        if ($entityId = $request->get('entity')) {
            $query->where('entity_id', new ObjectId($entityId));
        }

        if ($paymentMethod = $request->get('payment_method')) {
            $query->where('payment_method', $paymentMethod);
        }
    }

    //===================== #END# scopes ====================\\

    //===================== Relations ========================\\

    public function vendor()
    {
        return $this->belongsTo(Vendor::class)->withTrashed();
    }

    //===================== #END# Relations ========================\\
}
