<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Entities;

use App\Eloquent\Base;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Modules\CommonModule\Entities\City;
use Modules\CommonModule\Entities\Country;

class Entity extends Base
{
    use SoftDeletes;

    protected $table = 'entities';

    protected $guarded = [];

    protected $casts = [
        'is_active'             => 'boolean',
        'is_available'          => 'boolean'
    ];

    protected $dates = ['unavailable_date.from', 'unavailable_date.to'];

    //================ Scopes =========================\\

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    public function scopeFree($query)
    {
        return $query->where('state', 'free');
    }

    public function scopeFilterDate($query, Request $request)
    {
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

    //================ Helpers ========================\\

    public function isCarType() : bool
    {
        return ($this->type === 'car');
    }

    //================ #END# Helpers ========================\\


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

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
    //=============== #END# relation =====================\\
}
