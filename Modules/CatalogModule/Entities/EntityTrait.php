<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Entities;

trait EntityTrait
{

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

}
