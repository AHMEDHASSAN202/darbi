<?php

namespace Modules\CommonModule\Entities;


use Jenssegers\Mongodb\Eloquent\Model;

class Setting extends Model
{
    protected $guarded = [];

    public $preventActivityLog = ['_id', 'updated_at'];
}
