<?php

namespace Modules\BookingModule\Entities;

use App\Eloquent\Base;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;

class Booking extends Base
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['start_booking_at', 'end_booking_at', 'start_trip_at', 'end_trip_at', 'accepted_at'];

    protected $appends = ['expired_at'];

    protected static function newFactory()
    {
        return \Modules\BookingModule\Database\factories\BookingFactory::new();
    }

    //=============== Appends =====================\\
    public function getExpiredAtAttribute()
    {
        $time_interval_user_accept_min = getOption('time_interval_user_accept_min', 22);

        return optional($this->accepted_at)->addMinutes($time_interval_user_accept_min);
    }
    //=============== #END# Appends =====================\\

    //===================== scopes ====================\\

    public function scopeAdminSearch($query, Request $request)
    {
        if ($q = $request->get('q')) {
            $query->where(function ($query) use ($q) {
                $query->where('entity_details.name.ar', 'LIKE', '%'.$q.'%')->orWhere('entity_details.name.en', 'LIKE', '%'.$q.'%');
            });
        }
    }


    public function scopeAdminFilter($query, Request $request)
    {
        $status = $request->get('status');
        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }
    }

    //===================== #END# scopes ====================\\
}
