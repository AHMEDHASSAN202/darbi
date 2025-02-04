<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Repositories;

use Illuminate\Http\Request;
use Modules\CatalogModule\Entities\Extra;
use Modules\CommonModule\Traits\CrudRepositoryTrait;
use MongoDB\BSON\ObjectId;
use MongoDB\BSON\Regex;

class ExtraRepository
{
    use CrudRepositoryTrait;

    private $model;

    public function __construct(Extra $model)
    {
        $this->model = $model;
    }

    public function listWithPlugin(Request $request, $limit = null)
    {
        $page = \Illuminate\Pagination\Paginator::resolveCurrentPage();

        $aggregate = [
            [
                '$lookup'   => [
                    'from'          => 'plugins',
                    'localField'    => 'plugin_id',
                    'foreignField'  => '_id',
                    'as'            => 'plugin'
                ],
            ],
            [
                '$unwind'    => '$plugin',
            ],
            [
                '$match'        => [
                    'vendor_id'    => [ '$eq' => new ObjectId(getVendorId()) ]
                ]
            ],
            [
                '$sort'         => [
                    'created_at'    => -1
                ]
            ]
        ];

        if ($q = $request->get('q')) {
            $aggregate[] = [
                '$match'    => [
                    'plugin.name.en'       => [
                        '$regex'        => new Regex(".*$q", 'i')
                    ]
                ]
            ];
        }


        if ($entityType = $request->get('entity_type')) {
            $aggregate[] = [
                '$match'        => [
                    'plugin.entity_type'    => [ '$eq' => $entityType ]
                ]
            ];
        }

        $limit = (int)$limit;
        if ($limit) {
            $aggregateCount = $aggregate;
            $aggregateCount[] = [
                '$group' => [
                    '_id'   => null,
                    'count' => ['$sum' => 1]
                ]
            ];
            $total = optional($this->model->raw(function ($collection) use ($aggregateCount) { return $collection->aggregate($aggregateCount); })->first())->count;
            $aggregate[] = ['$skip' => ($page - 1) * $limit];
            $aggregate[] = ['$limit' => $limit];
        }

        $collection = $this->model->raw(function ($collection) use ($aggregate) { return $collection->aggregate($aggregate); });

        if ($limit) {
            return $this->model->_paginate($collection, $total, $limit, $page);
        }

        return $collection;
    }


    public function getExtras(array $extraIds, ObjectId $vendorId)
    {
        //get plugins with price
        return $this->model->raw(function ($collection) use ($extraIds, $vendorId) { return $collection->aggregate([
            [
                '$lookup'   => [
                    'from'          => 'plugins',
                    'localField'    => 'plugin_id',
                    'foreignField'  => '_id',
                    'as'            => 'plugin'
                ],
            ],
            [
                '$unwind'    => '$plugin',
            ],
            [
                '$match'        => [
                    'vendor_id'    => [ '$eq' => $vendorId ],
                    '_id'          => [
                        '$in'             => array_values(generateObjectIdOfArrayValues($extraIds))
                    ]
                ]
            ]
        ]); });
    }


    public function findByVendor(ObjectId $id, ObjectId $vendorId)
    {
        $extra = $this->model->raw(function ($collection) use ($id, $vendorId) { return $collection->aggregate([
                [
                    '$lookup'   => [
                        'from'          => 'plugins',
                        'localField'    => 'plugin_id',
                        'foreignField'  => '_id',
                        'as'            => 'plugin'
                    ],
                ],
                [
                    '$unwind'    => '$plugin',
                ],
                [
                    '$match'        => [
                        'vendor_id'    => [ '$eq' => $vendorId ],
                        '_id'          => [ '$eq' => $id ]
                    ]
                ]
            ]);
        });

        abort_if(!$extra->count(), 404);

        return $extra->first();
    }
}
