<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace App\Eloquent;

use Jenssegers\Mongodb\Eloquent\Model;

abstract class Base extends Model
{
    public function newEloquentBuilder($query)
    {
        return new Builder($query);
    }

    public function _paginate($collection, $total, $limit, $page)
    {
        return new \Illuminate\Pagination\LengthAwarePaginator($collection, $total, $limit, $page, [
            'path' => \Illuminate\Pagination\Paginator::resolveCurrentPath(),
        ]);
    }
}
