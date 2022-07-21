<?php

namespace Modules\BookingModule\Entities;

use App\Eloquent\Base;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Modules\BookingModule\Enums\BookingStatus;
use MongoDB\BSON\ObjectId;

class Booking extends Base
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['start_booking_at', 'end_booking_at', 'start_trip_at', 'end_trip_at', 'accepted_at'];

    protected $appends = ['expired_at'];

    const TIME_INTERVAL_USER_ACCEPT_MIN = 60;
    const TIME_INTERVAL_VENDOR_ACCEPT_MIN = 60;

    protected static function newFactory()
    {
        return \Modules\BookingModule\Database\factories\BookingFactory::new();
    }

    //=============== Appends =====================\\
    public function getExpiredAtAttribute()
    {
        $time_interval_user_accept_min = getOption('time_interval_user_accept_min', self::TIME_INTERVAL_USER_ACCEPT_MIN);

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
            if ($status === 'canceled') {
                $query->whereIn('status', [BookingStatus::CANCELLED_AFTER_ACCEPT, BookingStatus::CANCELLED_BEFORE_ACCEPT, BookingStatus::FORCE_CANCELLED]);
            }else {
                $query->where('status', $status);
            }
        }

        if ($vendor = $request->get('vendor')) {
            $query->where('vendor_id', new ObjectId($vendor));
        }

        if ($user = $request->get('user')) {
            $query->where('user_id', new ObjectId($user));
        }

        if ($bookId = $request->get('book_id')) {
            $query->where('_id', new ObjectId($bookId));
        }

        if ($city = $request->get('city')) {

        }

        if ($country = $request->get('country')) {
            $query->where('country_id', new ObjectId($country));
        }
    }


    public function scopeUserFilter($query, Request $request)
    {
        if ($status = $request->get('status')) {
            $request->validate(['status' => Rule::in([...BookingStatus::getStatus(), 'canceled'])]);
            if ($status === 'canceled') {
                $query->whereIn('status', [BookingStatus::CANCELLED_AFTER_ACCEPT, BookingStatus::CANCELLED_BEFORE_ACCEPT, BookingStatus::FORCE_CANCELLED]);
            }else {
                $query->where('status', $status);
            }
        }
    }

    //===================== #END# scopes ====================\\
}
