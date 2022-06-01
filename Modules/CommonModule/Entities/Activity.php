<?php

namespace Modules\CommonModule\Entities;


use App\Eloquent\Base;


class Activity extends Base
{
    protected $table = 'activity_log';

    public $guarded = [];

    protected $casts = [
        'properties' => 'object',
        'changed'    => 'object'
    ];
}
