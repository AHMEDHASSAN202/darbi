<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Services;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\CatalogModule\Repositories\ModelRepository;
use MongoDB\BSON\ObjectId;

trait EntityHelperService
{
    private function handleImages(?array $images, $dir = 'entities')
    {
        if (empty($images)) return [];

        return $this->uploadImages($dir, $images, ['300x300']);
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

        unset($images[$imageIndex]);

        $car->update(['images' => $images]);

        return $car;
    }


    public function createEntity(Request $request, $data = [])
    {
        $model = app(ModelRepository::class)->find($request->model_id);

        $images = $this->handleImages($request->images, $this->uploadDirectory);

        $unavailableDate = $this->prepareUnavailableDate($request->unavailable_date);

        $data = [
                'vendor_id'     => new ObjectId(getVendorId()),
                'model_id'      => new ObjectId($model->_id),
                'brand_id'      => new ObjectId($model->brand_id),
                'images'        => $images,
                'is_active'     => ($request->is_active === null) || (boolean)$request->is_active,
                'branch_ids'    => generateObjectIdOfArrayValues($request->branch_ids),
                'plugin_ids'    => generateObjectIdOfArrayValues($request->plugin_ids),
                'country_id'    => new ObjectId($request->country_id),
                'city_id'       => new ObjectId($request->city_id),
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

        $images = $car->images ?? [];

        $images = $images + $this->handleImages($request->images, $this->uploadDirectory);

        $unavailableDate = $this->prepareUnavailableDate($request->unavailable_date);

        $data = $data + [
                'model_id'      => new ObjectId($model->_id),
                'brand_id'      => new ObjectId($model->brand_id),
                'images'        => $images,
                'is_active'     => ($request->is_active === null) || (boolean)$request->is_active,
                'branch_ids'    => generateObjectIdOfArrayValues($request->branch_ids),
                'plugin_ids'    => generateObjectIdOfArrayValues($request->plugin_ids),
                'country_id'    => new ObjectId($request->country_id),
                'city_id'       => new ObjectId($request->city_id),
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
}
