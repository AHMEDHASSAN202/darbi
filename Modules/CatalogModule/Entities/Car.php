<?php

namespace Modules\CatalogModule\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Jenssegers\Mongodb\Eloquent\Builder;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Car extends \Jenssegers\Mongodb\Eloquent\Model
{
    use HasFactory, SoftDeletes, EntityTrait;

    protected $table = 'entities';

    protected $collection = 'entities';

    protected $guarded = [];

    protected $casts = [
        'is_active'         => 'boolean',
        'is_available'      => 'boolean'
    ];

    protected static function newFactory()
    {
        return \Modules\CatalogModule\Database\factories\CarFactory::new();
    }

    protected static function booted()
    {
        static::addGlobalScope('car', function (Builder $builder) {
            $builder->where('type', 'car');
        });
    }

    //=============== Relations =====================\\

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function model()
    {
        return $this->belongsTo(Model::class);
    }

    public function plugins()
    {
        return $this->belongsToMany(Plugin::class, null, 'entity_ids','plugin_ids');
    }

    //=============== #END# relation =====================\\

    //================ Scopes =========================\\

    public function scopeSearch($query, Request $request)
    {
        $q = $request->get('q');

        if (!$q) return $query;

        return $query->where(function ($query) use ($q) {
            $q = '%' . $q . '%';
            $query->whereHas('model', function ($query) use ($q) { $query->where('name.en', 'LIKE', $q)->orWhere('name.ar', 'LIKE', $q); })
                  ->orWhereHas('brand', function ($query) use ($q) { $query->where('name.en', 'LIKE', $q)->orWhere('name.ar', 'LIKE', $q); });
        });
    }

    public function scopeFilter($query, Request $request)
    {
        if ($brand = $request->get('brand')) {
            $query->where('brand_id', $brand);
        }

        if ($model = $request->get('model')) {
            $query->where('model_id', $model);
        }

        if ($city = $request->get('city')) {
            $query->where('city_id', $city);
        }

        if ($country = $request->get('country')) {
            $query->where('country_id', $country);
        }
    }

    //================ #END# scopes =========================\\
}
