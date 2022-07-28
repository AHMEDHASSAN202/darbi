<?php

namespace Modules\AuthModule\Entities;


use Jenssegers\Mongodb\Eloquent\Builder;

final class VendorAdmin extends Admin
{
    protected static function booted()
    {
        static::addGlobalScope('type', function (Builder $builder) {
            $builder->where('type', 'vendor');
        });
    }
}
