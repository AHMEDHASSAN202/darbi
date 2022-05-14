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
        if (!$request->get('q')) return;

        return $query->where('name', 'LIKE', '%'.$request->get('q').'%');
    }

    //========== #END# Scopes ==================\\


    //========== Relations ======================\\

    public function cities()
    {
        return $this->hasMany(City::class);
    }

    //=============== #END# =====================\\
}
