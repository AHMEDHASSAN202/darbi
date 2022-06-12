<?php

namespace Modules\CatalogModule\Entities;

use App\Eloquent\Base;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Extra extends Base
{
    use HasFactory;

    protected $guarded = [];

    protected static function newFactory()
    {
        return \Modules\CatalogModule\Database\factories\ExtraFactory::new();
    }
}
