<?php

namespace Modules\CommonModule\Entities;


use App\Eloquent\Base;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use MongoDB\BSON\ObjectId;

class Country extends Base
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected static function newFactory()
    {
        return \Modules\CommonModule\Database\factories\CountryFactory::new();
    }

    //========== Scopes ==================\\

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeSearch($query, Request $request)
    {
        $q = $request->get('q');

        if (!$q) return $query;

        return $query->where(function ($query) use ($q) {
            $q = '%'. $q .'%';
            $query->where('name.en', 'LIKE', $q)->orWhere('name.ar', 'LIKE', $q);
        });
    }

    public function scopeFilter($query, Request $request)
    {
        if ($me = auth(getCurrentGuard())->user()) {
            if ($me->isVendor()) {
                $query->where('_id', new ObjectId(optional($me->vendor)->country_id));
            }
        }
    }

    //========== #END# Scopes ==================\\


    //========== Relations ======================\\

    public function cities()
    {
        return $this->hasMany(City::class);
    }

    //=============== #END# =====================\\
}
