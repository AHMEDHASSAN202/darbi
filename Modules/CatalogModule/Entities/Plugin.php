<?php

namespace Modules\CatalogModule\Entities;

use App\Eloquent\Base;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Plugin extends Base
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
    public function entities()
    {
        return $this->belongsToMany(Entity::class, null, 'entity_ids', 'plugin_ids');
    }
    //===================#END# Relation ==============\\

    //================ Scopes =========================\\

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    //================ #END# Scopes =========================\\
}
