<?php

namespace Modules\CatalogModule\Entities;

use App\Eloquent\Base;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;

class Attribute extends Base
{
    use HasFactory;

    protected $guarded = [];

    //=============== Scopes ====================\\

    public function scopeFilters($query, Request $request)
    {
        if ($entityType = $request->get('entity_type')) {
            $query->where('entity_type', $entityType);
        }

        if ($type = $request->get('type')) {
            $query->where('type', $type);
        }
    }

    //=============== #END# Scopes ====================\\
}
