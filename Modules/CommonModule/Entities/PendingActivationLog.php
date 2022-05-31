<?php

namespace Modules\CommonModule\Entities;

use App\Eloquent\Base;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PendingActivationLog extends Base
{
    use HasFactory;

    protected $guarded = [];

    protected static function newFactory()
    {
        return \Modules\CommonModule\Database\factories\PendingActivationLogFactory::new();
    }
}
