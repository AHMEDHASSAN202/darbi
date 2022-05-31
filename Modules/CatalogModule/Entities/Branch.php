<?php

namespace Modules\CatalogModule\Entities;

use App\Eloquent\Base;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Modules\CommonModule\Entities\Region;

class Branch extends Base
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'is_active'         => 'boolean',
        'is_open'           => 'boolean'
    ];

    protected static function newFactory()
    {
        return \Modules\CatalogModule\Database\factories\BranchFactory::new();
    }

    //================ Scopes =========================\\

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOpened($query)
    {
        return $query->where('is_open', true);
    }

    //================ #END# scopes =========================\\

    //============= Relations ===================\\

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function regions()
    {
        return $this->belongsToMany(Region::class);
    }

    //============= #END# Relations ===================\\
}
