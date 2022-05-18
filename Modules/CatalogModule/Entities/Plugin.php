<?php

namespace Modules\CatalogModule\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Plugin extends \Jenssegers\Mongodb\Eloquent\Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'is_active'     => 'boolean'
    ];

    protected static function newFactory()
    {
        return \Modules\CatalogModule\Database\factories\PluginFactory::new();
    }

    //================== Relations ==================\\
    public function cars()
    {
        return $this->belongsToMany(Car::class, null, 'plugin_ids', 'car_ids');
    }
    //===================#END# Relation ==============\\

    //================ Scopes =========================\\

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    //================ #END# Scopes =========================\\
}
