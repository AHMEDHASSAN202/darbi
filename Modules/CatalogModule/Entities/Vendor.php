<?php

namespace Modules\CatalogModule\Entities;


use App\Eloquent\Base;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Modules\AuthModule\Entities\Admin;
use Modules\CatalogModule\Database\factories\VendorFactory;
use Modules\CommonModule\Entities\Country;
use MongoDB\BSON\ObjectId;


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

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
    //============= #END# Relations ===================\\

    //============= scopes ==============\\
    public function scopeSearch($query, Request $request)
    {
        if ($q = $request->get('q')) {
            return $query->where('name', 'LIKE', '%' . $q .'%');
        }
    }

    public function scopeFilter($query, Request $request)
    {
        if ($country = $request->get('country')) {
            $query->where('country_id', new ObjectId($country));
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
