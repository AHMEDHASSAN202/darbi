<?php

namespace Modules\CommonModule\Entities;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Country extends Model
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

    //========== #END# Scopes ==================\\


    //========== Relations ======================\\

    public function cities()
    {
        return $this->hasMany(City::class);
    }

    //=============== #END# =====================\\
}
