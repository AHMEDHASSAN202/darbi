<?php

namespace Modules\CatalogModule\Entities;

use App\Eloquent\Base;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Modules\CommonModule\Entities\City;
use Modules\CommonModule\Entities\Country;
use MongoDB\BSON\ObjectId;

class Port extends Base
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    protected static function newFactory()
    {
        return \Modules\CatalogModule\Database\factories\PortFactory::new();
    }


    //=============== Relations =====================\\

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    //=============== #END# relation =====================\\

    //================ Scopes =========================\\

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFilters($query, $request)
    {
        $countryId = $request->get('country') ?? $request->get('country_id');
        if ($countryId) {
            $query->where('country_id', new ObjectId($countryId));
        }
        if ($cityId = $request->get('city')) {
            $query->where('city_id', new ObjectId($cityId));
        }
    }

    public function scopeSearch($query, $request)
    {
        if ($q = $request->get('q')) {
            $query->where(function ($query) use ($q) {
                $q = '%' . $q . '%';
                $query->where('name.ar', 'LIKE', $q)->orWhere('name.en', 'LIKE', $q);
            });
        }
    }

    public function scopeAdminSearch($query, Request $request)
    {
        return $this->scopeSearch($query, $request);
    }

    public function scopeAdminFilters($query, Request $request)
    {
        $this->scopeFilters($query, $request);
    }

    //================ #END# scopes =========================\\
}
