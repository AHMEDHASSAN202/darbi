<?php

namespace Modules\CatalogModule\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Model extends \Jenssegers\Mongodb\Eloquent\Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'is_active'         => 'boolean'
    ];

    protected $appends = ['addons'];


    protected static function newFactory()
    {
        return \Modules\CatalogModule\Database\factories\ModelFactory::new();
    }

    //================ Scopes =========================\\

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    //================ #END# scopes =========================\\

    public function getAddonsAttribute()
    {
        if (!$this->specs || !is_array($this->specs)) {
            return [];
        }

        $specs = [];

        foreach ($this->specs as $key => $spec) {
            $specs[$spec['group_details']['key']]['group_key'] = $spec['group_details']['key'];
            $specs[$spec['group_details']['key']]['group_name'] = translateAttribute($spec['group_details']);
            $specs[$spec['group_details']['key']]['specs'][] = $spec + ['key' => $key];
        }

        return collect($specs)->sortBy('*.specs.order_weight');
    }
}
