<?php

namespace Modules\AddonsModule\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plugin extends \Jenssegers\Mongodb\Eloquent\Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function newFactory()
    {
        return \Modules\AddonsModule\Database\factories\PluginFactory::new();
    }
}
