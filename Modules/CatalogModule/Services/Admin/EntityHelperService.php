<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Services\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
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
            return null;
        }

        unset($images[$imageIndex]);
        $car->update(['images' => array_values($images)]);

        return $car;
    }


    public function createEntity(Request $request, $data = [])
    {
        $model = app(ModelRepository::class)->find($request->model_id);

        $images = $this->handleImages($request->images, $this->uploadDirectory);

        $unavailableDate = $this->prepareUnavailableDate($request->unavailable_date);

        $countryId = auth('vendor_api')->user()->vendor->country_id;

        $data = [
                'name'          => $request->name,
                'vendor_id'     => new ObjectId(getVendorId()),
                'model_id'      => new ObjectId($model->_id),
                'brand_id'      => new ObjectId($model->brand_id),
                'images'        => $images,
                'is_active'     => ($request->is_active === null) || (boolean)$request->is_active,
                'is_available'  => true,
                'extra_ids'     => generateObjectIdOfArrayValues($request->extra_ids),
                'country_id'    => new ObjectId($countryId),
                'price'         => floatval($request->price),
                'price_unit'    => $request->price_unit,
                'unavailable_date'  => $unavailableDate
            ] + $data;

        return $this->repository->create($data);
    }



    public function updateEntity($id, Request $request, $data = [])
    {
        $entity = $this->repository->find($id, ['vendor_id' => new ObjectId(getVendorId())]);

        $model = app(ModelRepository::class)->find($request->model_id);

        $images = $entity->images ?? [];

        $images = array_merge($images, $this->handleImages($request->images, $this->uploadDirectory));

        $unavailableDate = $this->prepareUnavailableDate($request->unavailable_date);

        $data = $data + [
                'name'          => $request->name,
                'model_id'      => new ObjectId($model->_id),
                'brand_id'      => new ObjectId($model->brand_id),
                'images'        => $images,
                'is_active'     => ($request->is_active === null) || (boolean)$request->is_active,
                'extra_ids'     => generateObjectIdOfArrayValues($request->extra_ids),
                'price'         => floatval($request->price),
                'price_unit'    => $request->price_unit,
                'unavailable_date'  => $unavailableDate
            ];

       $entity->update($data);

       return $entity;
    }


    public function delete($id)
    {
        return $this->repository->destroy($id, ['vendor_id' => new ObjectId(getVendorId())]);
    }


    public function findAllByVendor(Request $request)
    {
        $cars = $this->repository->findAllByVendor($request, getVendorId());

        return new PaginateResource(EntityResource::collection($cars));
    }


    public function findByVendor($id)
    {
        $id = new ObjectId($id);
        $vendorId = new ObjectId(getVendorId());
        $yacht = $this->repository->findByVendor($vendorId, $id);

        return new FindEntityResource($yacht);
    }
}
