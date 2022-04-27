<?php

namespace Modules\CommonModule\Entities;


use Jenssegers\Mongodb\Eloquent\Model;


class Activity extends Model
{
    protected $table = 'activity_log';

    public $guarded = [];

    protected $casts = [
        'properties' => 'object',
        'changed'    => 'object'
    ];
}
