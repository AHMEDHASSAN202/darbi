<?php

namespace Modules\CatalogModule\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function newFactory()
    {
        return \Modules\CatalogModule\Database\factories\BranchFactory::new();
    }

    //============= Relations ===================\\

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    //============= #END# Relations ===================\\
}
