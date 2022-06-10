<?php

namespace Modules\BookingModule\Entities;

use App\Eloquent\Base;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
}
