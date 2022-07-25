<?php

namespace Modules\CatalogModule\Entities;

use App\Casts\ObjectIdCast;
use App\Eloquent\Base;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use MongoDB\BSON\ObjectId;

class Model extends Base
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'is_active'         => 'boolean'
    ];

    protected static function newFactory()
    {
        return \Modules\CatalogModule\Database\factories\ModelFactory::new();
    }

    //================ Scopes =========================\\

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeAdminSearch($query, Request $request)
    {
        $q = $request->get('q');

        if (!$q) return $query;

        return $query->where(function ($query) use ($q) {
            $q = '%' . $q . '%';
            $query->where('name.en', 'LIKE', $q)->orWhere('name.ar', 'LIKE', $q);
        });
    }

    public function scopeAdminFilters($query, Request $request)
    {
        if ($brand = $request->get('brand')) {
            $query->where('brand_id', new ObjectId($brand));
        }

        if ($entityType = $request->get('entity_type')) {
            $query->where('entity_type', $entityType);
        }
    }

    //================ #END# scopes =========================\\


    //=============== relations ======================\\

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    //================ #END# relations ================\\

}
