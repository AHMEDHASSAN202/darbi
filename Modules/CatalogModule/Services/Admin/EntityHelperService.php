<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Services\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\CatalogModule\Enums\EntityStatus;
use Modules\CatalogModule\Repositories\ModelRepository;
use Modules\CatalogModule\Transformers\Admin\EntityResource;
use Modules\CatalogModule\Transformers\Admin\FindEntityResource;
use Modules\CommonModule\Transformers\PaginateResource;
use MongoDB\BSON\ObjectId;
use function app;
use function generateObjectIdOfArrayValues;
use function getVendorId;

trait EntityHelperService
{
    private function handleImages(?array $images, $dir = 'entities')
    {
        if (empty($images)) return [];

        return $this->uploadImages($dir, $images);
    }

    private function prepareUnavailableDate(?array $unavailableDate)
    {
        if (!empty($unavailableDate) && isset($unavailableDate['from']) && isset($unavailableDate['to'])) {
            return [
                'from'              => new \MongoDB\BSON\UTCDateTime(Carbon::parse($unavailableDate['from'])),
                'to'                => new \MongoDB\BSON\UTCDateTime(Carbon::parse($unavailableDate['to']))
            ];
        }

        return null;
    }


    public function removeImage($id, $imageIndex)
    {
        $car = $this->repository->find($id, ['vendor_id' => new ObjectId(getVendorId())]);

        $images = $car->images;

        if (empty($images)) {
            return badResponse();
        }

        $image = $images[$imageIndex];

        unset($images[$imageIndex]);

        $updated = $car->update(['images' => array_values($images)]);

        if ($updated) {
            $this->_removeImage($image);
        }

        return deletedResponse($car);
    }


    public function createEntity(Request $request, $data = [])
    {
        $images = $this->handleImages($request->images, $this->uploadDirectory);

        $unavailableDate = $this->prepareUnavailableDate($request->unavailable_date);

        $countryId = optional(auth('vendor_api')->user()->vendor)->country_id;

        $data = [
                'name'          => $request->name,
                'vendor_id'     => new ObjectId(getVendorId()),
                'images'        => $images,
                'is_active'     => ($request->is_active === null) || (boolean)$request->is_active,
                'is_available'  => true,
                'extra_ids'     => generateObjectIdOfArrayValues($request->extra_ids),
                'country_id'    => new ObjectId($countryId),
                'price'         => floatval($request->price),
                'price_unit'    => $request->price_unit,
                'unavailable_date'  => $unavailableDate,
                'built_date'    => (int)$request->built_date,
                'attributes'    => $request->get('attributes')
            ] + $data;

        return $this->repository->create($data);
    }



    public function updateEntity($id, Request $request, $data = [])
    {
        $entity = $this->repository->find($id, ['vendor_id' => new ObjectId(getVendorId())]);

        $images = $entity->images ?? [];

        $images = array_merge($images, $this->handleImages($request->images, $this->uploadDirectory));

        $unavailableDate = $this->prepareUnavailableDate($request->unavailable_date);

        $data = $data + [
                'name'          => $request->name,
                'images'        => $images,
                'is_active'     => ($request->is_active === null) || (boolean)$request->is_active,
                'extra_ids'     => generateObjectIdOfArrayValues($request->extra_ids),
                'price'         => floatval($request->price),
                'price_unit'    => $request->price_unit,
                'unavailable_date'  => $unavailableDate,
                'attributes'    => $request->get('attributes')
            ];

       $entity->update($data);

       return $entity;
    }


    public function delete($id)
    {
        $entity = $this->repository->find($id, ['vendor_id' => new ObjectId(getVendorId())]);

        if ($entity->state != EntityStatus::FREE) {
            return badResponse([], __('Entity is not free'));
        }

        $entity->delete();

        return deletedResponse();
    }


    public function deleteByAdmin($id)
    {
        $entity = $this->repository->find($id);

        if ($entity->state != EntityStatus::FREE) {
            return badResponse([], __('Entity is not free'));
        }

        $entity->delete();

        return deletedResponse();
    }


    public function findAllByVendor(Request $request)
    {
        $entities = $this->repository->findAllByVendor($request, getVendorId());

        if ($entities instanceof LengthAwarePaginator) {
            return new PaginateResource(EntityResource::collection($entities));
        }

        return EntityResource::collection($entities);
    }


    public function findByVendor($id)
    {
        $id = new ObjectId($id);
        $vendorId = new ObjectId(getVendorId());
        $entity = $this->repository->findByVendor($vendorId, $id);

        return new FindEntityResource($entity);
    }


    public function findAll(Request $request)
    {
        $cars = $this->repository->findAll($request);

        if ($cars instanceof LengthAwarePaginator) {
            return new PaginateResource(EntityResource::collection($cars));
        }

        return EntityResource::collection($cars);
    }


    public function find($id)
    {
        $id = new ObjectId($id);

        $entity = $this->repository->findOne($id);

        return new FindEntityResource($entity);
    }


    private function handleAttributes(array $attributes)
    {
        if (empty($attributes)) {
            return [];
        }

        $storeAttributes = [];

        foreach ($attributes as $attribute) {
            //add
            $storeAttributes[$attribute['key']] = [
                'value' => $attribute['value'],
                'image' => $attribute['image'],
                'key'   => $attribute['key'],
            ];
        }

        return $storeAttributes;
    }
}
