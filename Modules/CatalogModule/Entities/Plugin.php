<?php

namespace Modules\CatalogModule\Entities;

use App\Eloquent\Base;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
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
        return $this->belongsToMany(Entity::class, null, 'plugin_ids', 'entity_ids');
    }
    //===================#END# Relation ==============\\

    //================ Scopes =========================\\

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFilters($query, Request $request)
    {
        if ($entityType = $request->get('entity_type')) {
            $query->where('entity_type', $entityType);
        }
    }

    public function scopeSearch($query, Request $request)
    {
        if ($q = $request->get('q')) {
            $query->where(function ($query) use ($q) {
                $query->where('name.ar', 'LIKE', '%' . $q . '%')->orWhere('name.en', 'LIKE', '%' . $q . '%');
            });
        }
    }

    //================ #END# Scopes =========================\\
}
