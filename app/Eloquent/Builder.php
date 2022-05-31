<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace App\Eloquent;

use Illuminate\Database\Eloquent\Relations\Relation;
use MongoDB\BSON\ObjectId;

class Builder extends \Jenssegers\Mongodb\Eloquent\Builder
{
    public function addHybridHas(Relation $relation, $operator = '>=', $count = 1, $boolean = 'and', \Closure $callback = null)
    {
        $hasQuery = $relation->getQuery();

        if ($callback) {
            $hasQuery->callScope($callback);
        }

        // If the operator is <, <= or !=, we will use whereNotIn.
        $not = in_array($operator, ['<', '<=', '!=']);
        // If we are comparing to 0, we need an additional $not flip.
        if ($count == 0) {
            $not = ! $not;
        }

        $relations = $hasQuery->pluck($this->getHasCompareKey($relation));

        $relatedIds = $this->getConstrainedRelatedIds($relations, $operator, $count);

        $relatedIds = array_map(function ($id) {
            if ($id) {
                return new ObjectId($id);
            }
        }, $relatedIds);

        return $this->whereIn($this->getRelatedConstraintKey($relation), $relatedIds, $boolean, $not);
    }
}
