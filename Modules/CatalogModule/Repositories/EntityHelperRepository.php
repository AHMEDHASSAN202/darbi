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
//        return $this->model->with(['model', 'brand', 'country', 'city', 'extras', 'branches'])->where('vendor_id', new ObjectId($vendorId))->findOrFail($carId);
        $entity = $this->model->raw(function ($collection) use ($vendorId, $entityId) {
            return $collection->aggregate([
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
                        'localField'    => 'branch_ids',
                        'foreignField'  => '_id',
                        'as'            => 'branches'
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
                    '$match'        => [
                        'vendor_id'    => [ '$eq' => $vendorId ],
                        '_id'          => [ '$eq' => $entityId ],
                    ]
                ]
            ]);
        });

        abort_if(!$entity->count(), 404);

        return $entity->first();
    }
}
