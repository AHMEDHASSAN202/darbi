<?php

namespace Modules\UserModule\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class SavedPlace extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function newFactory()
    {
        return \Modules\UserModule\Database\factories\SavedPlaceFactory::new();
    }
}
