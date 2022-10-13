<?php

namespace Modules\CommonModule\Entities;

use App\Eloquent\Base;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;

class CarType extends Base
{
    use HasFactory;

    protected $guarded = [];

    protected static function newFactory()
    {
        return \Modules\CommonModule\Database\factories\CarTypeFactory::new();
    }

    //========== Scopes ==================\\

    public function scopeSearch($query, Request $request)
    {
        $q = $request->get('q');

        if (!$q) return $query;

        return $query->where('name', 'LIKE', '%'. $q .'%');
    }

    //========== #END# Scopes ==================\\
}
