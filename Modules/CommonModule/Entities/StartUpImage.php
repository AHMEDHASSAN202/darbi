<?php

namespace Modules\CommonModule\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class StartUpImage extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['valid_from', 'valid_to'];

    protected static function newFactory()
    {
        return \Modules\CommonModule\Database\factories\StartUpImageFactory::new();
    }

    //========== Scopes ==================\\

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeValid($query)
    {
        return $query->where('valid_from', '<=', now())->where('valid_to', '>=', now());
    }

    //========== #END# Scopes ==================\\
}
