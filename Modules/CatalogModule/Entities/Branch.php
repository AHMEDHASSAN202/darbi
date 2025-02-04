<?php

namespace Modules\CatalogModule\Entities;

use App\Eloquent\Base;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Modules\CommonModule\Entities\City;
use Modules\CommonModule\Entities\Country;
use Modules\CommonModule\Entities\Region;
use MongoDB\BSON\ObjectId;

class Branch extends Base
{
    use HasFactory, SoftDeletes;

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

    public function scopeAdminSearch($query, Request $request)
    {
        if ($q = $request->get('q')) {
            $query->where(function ($query) use ($q) { $query->where('name.ar', 'LIKE', '%'.$q.'%')->orWhere('name.en', 'LIKE', '%'.$q.'%'); });
        }
    }

    public function scopeAdminFilters($query, Request $request)
    {
        if ($cityId = $request->get('city')) {
            $query->where('city_id', new ObjectId($cityId));
        }

        if ($vendorId = $request->get('vendor')) {
            $query->where('vendor_id', new ObjectId($vendorId));
        }
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

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    //============= #END# Relations ===================\\
}
