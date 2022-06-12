<?php

namespace Modules\CatalogModule\Entities;

use App\Eloquent\Base;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Modules\CommonModule\Entities\Country;

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

    //=============== #END# relation =====================\\

    //================ Scopes =========================\\

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeSearch($query, $request)
    {
        if ($countryId = $request->get('country_id')) {
            $query->where('country_id', $countryId);
        }
    }

    public function scopeAdminSearch($query, Request $request)
    {
        return $this->scopeSearch($query, $request);
    }

    public function scopeAdminFilters($query, Request $request)
    {

    }

    //================ #END# scopes =========================\\
}
