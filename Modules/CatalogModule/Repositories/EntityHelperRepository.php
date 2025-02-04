<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Repositories;

use Illuminate\Http\Request;
use Modules\CatalogModule\Entities\Car;
use Modules\CommonModule\Traits\CrudRepositoryTrait;
use MongoDB\BSON\ObjectId;

trait EntityHelperRepository
{
    use CrudRepositoryTrait;

    public function findByVendor($vendorId, $entityId)
    {
        return $this->findOne($entityId, $vendorId);
    }


    public function findOne($entityId, $vendorId = null)
    {
        $match = [
            '_id'          => [ '$eq' => $entityId ],
            'deleted_at'   => [ '$eq' => null ]
        ];

        if ($vendorId) {
            $match['vendor_id'] = [ '$eq' => $vendorId ];
        }

        $entity = $this->model->raw(function ($collection) use ($match) {
            return $collection->aggregate([
                [
                    '$match'        => $match
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
                        'from'          => 'vendors',
                        'localField'    => 'vendor_id',
                        'foreignField'  => '_id',
                        'as'            => 'vendor'
                    ],
                ],
                [
                    '$unwind'    => [
                        "path"      => '$vendor',
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
                        'from'          => 'cities',
                        'localField'    => 'city_id',
                        'foreignField'  => '_id',
                        'as'            => 'city'
                    ],
                ],
                [
                    '$unwind'    => [
                        "path"      => '$city',
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
                [
                    '$lookup'   => [
                        'from'          => 'branches',
                        'localField'    => 'branch_id',
                        'foreignField'  => '_id',
                        'as'            => 'branch'
                    ],
                ],
                [
                    '$unwind'    => [
                        "path"      => '$branch',
                        "preserveNullAndEmptyArrays" => true
                    ],
                ],
                [
                    '$lookup'   => [
                        'from'          => 'ports',
                        'localField'    => 'port_id',
                        'foreignField'  => '_id',
                        'as'            => 'port'
                    ],
                ],
                [
                    '$unwind'    => [
                        "path"      => '$port',
                        "preserveNullAndEmptyArrays" => true
                    ],
                ],
                [
                    '$lookup'   => [
                        'from'          => 'car_types',
                        'localField'    => 'car_type_id',
                        'foreignField'  => '_id',
                        'as'            => 'car_type'
                    ],
                ],
                [
                    '$unwind'    => [
                        "path"      => '$car_type',
                        "preserveNullAndEmptyArrays" => true
                    ],
                ]
            ]);
        });

        abort_if(!$entity->count(), 404);

        return $entity->first();
    }
}
