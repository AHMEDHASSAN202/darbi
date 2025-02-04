<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Entities;

use App\Eloquent\Base;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Modules\CatalogModule\Enums\EntityStatus;
use Modules\CatalogModule\Enums\EntityType;
use Modules\CatalogModule\Repositories\BranchRepository;
use Modules\CatalogModule\Repositories\PortRepository;
use Modules\CommonModule\Entities\City;
use Modules\CommonModule\Entities\Country;
use MongoDB\BSON\ObjectId;

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
        return $query->where('state', EntityStatus::FREE);
    }

    public function scopeFreeOrPending($query)
    {
        return $query->whereIn('state', [EntityStatus::FREE, EntityStatus::PENDING]);
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

    public function scopeFilter($query, Request $request, $type)
    {
        if ($brand = $request->get('brand')) {
            $query->where('brand_id', new ObjectId($brand));
        }

        if ($model = $request->get('model')) {
            $query->where('model_id', new ObjectId($model));
        }

        if ($city = $request->get('city')) {
            if ($type === EntityType::CAR) {
                $branchIds = app(BranchRepository::class)->findAllBranchesByCity($city)->pluck('_id')->toArray();
                $query->whereIn('branch_id', generateObjectIdOfArrayValues($branchIds));
            }elseif ($type === EntityType::YACHT) {
                $portIds = app(PortRepository::class)->findAllPortsByCity($city)->pluck('_id')->toArray();
                $query->whereIn('port_id', generateObjectIdOfArrayValues($portIds));
            }elseif ($type === EntityType::VILLA) {
                $query->where('city_id', new ObjectId($city));
            }
        }

        if ($country = $request->get('country')) {
            $query->where('country_id', new ObjectId($country));
        }

        if ($region = $request->get('region')) {
            $branchIds = app(BranchRepository::class)->findAllBranchesByRegion($region, true)->pluck('_id')->toArray();
            $query->whereIn('branch_id', generateObjectIdOfArrayValues($branchIds));
        }

        if ($priceFrom = $request->get('price_from')) {
            $query->where('price', '>=', intval($priceFrom));
        }

        if ($priceTo = $request->get('price_to')) {
            $query->where('price', '<=', intval($priceTo));
        }
    }

    public function scopeAdminFilter($query, Request $request, $type)
    {
        $state = $request->get('state');
        if ($state && $state != 'all') {
            $query->where('state', $state);
        }

        if ($branch = $request->get('branch')) {
            $query->where('branch_id', new ObjectId($branch));
        }

        return $this->scopeFilter($query, $request, $type);
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

    //================ #END# scopes =========================\\

    //================ Helpers ========================\\

    public function isCarType() : bool
    {
        return ($this->type === 'car');
    }

    public function isYachtType() : bool
    {
        return ($this->type === 'yacht');
    }

    public function getPluginIdsAttribute($value)
    {
        if (empty($value)) return [];

        return array_map(function ($id) { return (string)$id; }, $value);
    }


    public function getBranchIdsAttribute($value)
    {
        $value = @(array)$value;

        if (empty($value)) return [];

        return array_map(function ($id) { return (string)$id; }, $value);
    }


    public function getUnavailableDateAttribute($value)
    {
        if (empty($value)) return [];
        return [
            'from'          => $value['from']->toDateTime(),
            'to'            => $value['to']->toDateTime()
        ];
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

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    //=============== #END# relation =====================\\
}
