<?php

namespace Modules\CarModule\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Builder;
use Jenssegers\Mongodb\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $table = 'entities';

    protected $guarded = [];

    protected static function newFactory()
    {
        return \Modules\CarModule\Database\factories\CarFactory::new();
    }

    protected static function booted()
    {
        static::addGlobalScope('car', function (Builder $builder) {
            $builder->where('type', 'car');
        });
    }
}
