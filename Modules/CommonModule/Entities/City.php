<?php

namespace Modules\CommonModule\Entities;

use App\Eloquent\Base;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use MongoDB\BSON\ObjectId;

class City extends Base
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
        $q = $request->get('q');

        if (!$q) return $query;

        return $query->where(function ($query) use ($q) {
            $q = '%'. $q .'%';
            return $query->where('name.en', 'LIKE', $q)->orWhere('name.ar', 'LIKE', $q);
        });
    }

    public function scopeFilter($query, Request $request)
    {
        if ($countryId = $request->get('country')) {
            $query->where('country_id', new ObjectId($countryId));
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
        return $this->belongsTo(Country::class);
    }

    //=============== #END# =====================\\
}
