<?php

namespace Modules\CatalogModule\Entities;


use App\Eloquent\Base;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Modules\CatalogModule\Database\factories\VendorFactory;


class Vendor extends Base
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $hidden = ['deleted_at'];

    protected static function newFactory()
    {
        return VendorFactory::new();
    }

    //============= Relations ===================\\

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    //============= #END# Relations ===================\\

    //============= scopes ==============\\
    public function scopeAdminSearch($query)
    {
        if ($q = request()->q) {
            return $query->where('name', 'LIKE', '%' . $q .'%');
        }
    }
    //============= #END# scopes ==============\\

    public function isNotActive() : bool
    {
        return ($this->is_active !== true);
    }

    public function isCar()
    {
        return $this->type === 'car';
    }

    public function isYacht()
    {
        return $this->type === 'yacht';
    }
}
