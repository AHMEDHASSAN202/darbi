<?php

namespace Modules\YachtModule\Entities;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Builder;
use Jenssegers\Mongodb\Eloquent\Model;

class Yacht extends Model
{
    use HasFactory;

    protected $table = 'entities';

    protected $guarded = [];

    protected static function newFactory()
    {
        return \Modules\YachtModule\Database\factories\YachtFactory::new();
    }

    protected static function booted()
    {
        static::addGlobalScope('yacht', function (Builder $builder) {
            $builder->where('type', 'yacht');
        });
    }
}
