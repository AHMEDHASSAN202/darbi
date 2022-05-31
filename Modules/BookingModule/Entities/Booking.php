<?php

namespace Modules\BookingModule\Entities;

use App\Eloquent\Base;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\CatalogModule\Entities\Entity;

class Booking extends Base
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['start_booking_at', 'end_booking_at'];

    protected static function newFactory()
    {
        return \Modules\BookingModule\Database\factories\BookingFactory::new();
    }


    //=================== relations ====================\\

    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }

    //=================== #END# relations ====================\\
}
