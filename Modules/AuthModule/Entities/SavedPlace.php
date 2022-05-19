<?php

namespace Modules\AuthModule\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use Modules\CatalogModule\Entities\Vendor;
use Modules\CommonModule\Entities\Region;

class SavedPlace extends Model
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
