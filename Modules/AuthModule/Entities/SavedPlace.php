<?php

namespace Modules\AuthModule\Entities;

use App\Eloquent\Base;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\CommonModule\Entities\Region;

class SavedPlace extends Base
{
    use HasFactory;

    protected $guarded = [];

    protected static function newFactory()
    {
        return \Modules\AuthModule\Database\factories\SavedPlaceFactory::new();
    }

    //============= Relations ===================\\

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    //============= #END# Relations ===================\\
}
