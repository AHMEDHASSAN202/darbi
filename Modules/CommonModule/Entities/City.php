<?php

namespace Modules\CommonModule\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class City extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected static function newFactory()
    {
        return \Modules\CommonModule\Database\factories\CityFactory::new();
    }

    //========== Scopes ==================\\

    public function scopeSearch($query, Request $request)
    {
        if (!$request->get('q')) return;

        return $query->where('name', 'LIKE', '%'.$request->get('q').'%');
    }

    public function scopeFilter($query, Request $request)
    {
        if ($countryCode = $request->get('country')) {
            $query->where('country_code', $countryCode);
        }
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    //========== #END# Scopes ==================\\

    //========== Relations ======================\\

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_code', 'code');
    }

    //=============== #END# =====================\\
}
