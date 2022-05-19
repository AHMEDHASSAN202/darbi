<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Entities;

use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Entity extends \Jenssegers\Mongodb\Eloquent\Model
{
    use SoftDeletes;

    protected $table = 'entities';

    protected $guarded = [];

    protected $casts = [
        'is_active'         => 'boolean',
        'is_available'      => 'boolean'
    ];

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

    //=============== #END# relation =====================\\

}
