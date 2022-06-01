<?php

namespace Modules\CatalogModule\Entities;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Jenssegers\Mongodb\Eloquent\Builder;
use MongoDB\BSON\ObjectId;

class Yacht extends Entity
{
    use HasFactory;

    protected static function newFactory()
    {
        return \Modules\CatalogModule\Database\factories\YachtFactory::new();
    }

    protected static function booted()
    {
        static::addGlobalScope('yacht', function (Builder $builder) {
            $builder->where('type', 'yacht');
        });
    }



    //=============== Relations =====================\\

    public function port()
    {
        return $this->belongsTo(Port::class);
    }

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

    public function scopeFilter($query, Request $request)
    {
        if ($city = $request->get('city')) {
            $query->where('city_id', new ObjectId($city));
        }

        if ($country = $request->get('country')) {
            $query->where('country_id', new ObjectId($country));
        }

        if ($fromDate = $request->get('from_date')) {
            $query->where(function ($query) use ($fromDate) {
                try {
                    $query->whereNull('unavailable_date')->orWhere('unavailable_date.from', '>', new \DateTime($fromDate))->orWhere('unavailable_date.to', '<', new \DateTime($fromDate));
                }catch (\Exception $exception) {
                    Log::error('fromDateFilter: ' . $exception->getMessage());
                }
            });
        }

        if ($toDate = $request->get('to_date')) {
            $query->where(function ($query) use ($toDate) {
                try {
                    $query->whereNull('unavailable_date')->orWhere('unavailable_date.to', '<', new \DateTime($toDate))->orWhere('unavailable_date.from', '>', new \DateTime($toDate));
                }catch (\Exception $exception) {
                    Log::error('toDateFilter: ' . $exception->getMessage());
                }
            });
        }
    }

    //================ #END# scopes =========================\\
}
