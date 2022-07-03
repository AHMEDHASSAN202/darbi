<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Repositories;

use Illuminate\Support\Facades\Log;
use Modules\CatalogModule\Entities\Entity;
use MongoDB\BSON\ObjectId;

class EntityRepository
{
    public function __construct(Entity $model)
    {
        $this->model = $model;
    }

    public function findById($entityId)
    {
        $entity = $this->model->raw(function ($collection) use ($entityId) {
            return $collection->aggregate([
                [
                    '$match'        => [
                        '_id'          => [ '$eq' => new ObjectId($entityId) ],
                    ]
                ],
                [
                    '$lookup'   => [
                        'from'          => 'models',
                        'localField'    => 'model_id',
                        'foreignField'  => '_id',
                        'as'            => 'model'
                    ],
                ],
                [
                    '$unwind'    => [
                        "path"      => '$model',
                        "preserveNullAndEmptyArrays" => true
                    ],
                ],
                [
                    '$lookup'   => [
                        'from'          => 'brands',
                        'localField'    => 'brand_id',
                        'foreignField'  => '_id',
                        'as'            => 'brand'
                    ],
                ],
                [
                    '$unwind'    => [
                        "path"      => '$brand',
                        "preserveNullAndEmptyArrays" => true
                    ],
                ],
                [
                    '$lookup'   => [
                        'from'          => 'countries',
                        'localField'    => 'country_id',
                        'foreignField'  => '_id',
                        'as'            => 'country'
                    ],
                ],
                [
                    '$unwind'    => [
                        "path"      => '$country',
                        "preserveNullAndEmptyArrays" => true
                    ],
                ],
                [
                    '$lookup'   => [
                        'from'          => 'extras',
                        'localField'    => 'extra_ids',
                        'foreignField'  => '_id',
                        'as'            => 'extras'
                    ],
                ],
                [
                    '$lookup'   => [
                        'from'          => 'plugins',
                        'localField'    => 'extras.plugin_id',
                        'foreignField'  => '_id',
                        'as'            => 'plugins'
                    ],
                ],
            ]);
        });

        abort_if(!$entity->count(), 404);

        return $entity->first();
    }

    public function changeState($entityId, $state)
    {
        try {
            return $this->model->where('_id', new ObjectId($entityId))->update(['state' => $state]);
        }catch (\Exception $exception) {
            Log::error('change state error: ' . $exception->getMessage());
            return false;
        }
    }

    public function findWithBasicData($id)
    {
        $entity = $this->model->raw(function ($collection) use ($id) {
            return $collection->aggregate([
                [
                    '$match'        => [
                        '_id'          => [ '$eq' => new ObjectId($id) ],
                    ]
                ],
                [
                    '$lookup'   => [
                        'from'          => 'models',
                        'localField'    => 'model_id',
                        'foreignField'  => '_id',
                        'as'            => 'model'
                    ],
                ],
                [
                    '$unwind'    => [
                        "path"      => '$model',
                        "preserveNullAndEmptyArrays" => true
                    ],
                ],
                [
                    '$lookup'   => [
                        'from'          => 'brands',
                        'localField'    => 'brand_id',
                        'foreignField'  => '_id',
                        'as'            => 'brand'
                    ],
                ],
                [
                    '$unwind'    => [
                        "path"      => '$brand',
                        "preserveNullAndEmptyArrays" => true
                    ],
                ]
            ]);
        });

        abort_if(!$entity->count(), 404);

        return $entity->first();
    }
}
