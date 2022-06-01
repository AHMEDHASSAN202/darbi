<?php

namespace Modules\CommonModule\Entities;


use App\Eloquent\Base;

class Setting extends Base
{
    protected $guarded = [];

    public $preventActivityLog = ['_id', 'updated_at'];
}
