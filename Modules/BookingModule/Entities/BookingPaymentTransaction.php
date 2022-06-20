<?php

namespace Modules\BookingModule\Entities;

use App\Eloquent\Base;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;

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

    //===================== #END# scopes ====================\\
}
