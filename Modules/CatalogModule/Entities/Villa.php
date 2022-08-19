<?php

namespace Modules\CatalogModule\Entities;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Jenssegers\Mongodb\Eloquent\Builder;
use Modules\CatalogModule\Enums\EntityType;
use MongoDB\BSON\ObjectId;

class Villa extends Entity
{
    use HasFactory;

    protected static function newFactory()
    {
        return \Modules\CatalogModule\Database\factories\VillaFactory::new();
    }

    protected static function booted()
    {
        static::addGlobalScope('villa', function (Builder $builder) {
            $builder->where('type', EntityType::VILLA);
        });
    }



    //=============== Relations =====================\\


    //=============== #END# relation =====================\\


    //================ Scopes =========================\\

    public function scopeSearch($query, Request $request)
    {
        $q = $request->get('q');

        if (!$q) return $query;

        return $query->where(function ($query) use ($q) {
            $q = '%' . $q . '%';
            $query->where('name.en', 'LIKE', $q)->orWhere('name.ar', 'LIKE', $q);
        });
    }

    //================ #END# scopes =========================\\
}
