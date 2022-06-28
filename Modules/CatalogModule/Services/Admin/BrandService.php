<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Services\Admin;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\CatalogModule\Http\Requests\Admin\CreateBrandRequest;
use Modules\CatalogModule\Http\Requests\Admin\CreatePortRequest;
use Modules\CatalogModule\Http\Requests\Admin\UpdateBrandRequest;
use Modules\CatalogModule\Http\Requests\Admin\UpdatePortRequest;
use Modules\CatalogModule\Repositories\BrandRepository;
use Modules\CatalogModule\Transformers\Admin\BrandResource;
use Modules\CatalogModule\Transformers\Admin\FindBrandResource;
use Modules\CatalogModule\Transformers\Admin\FindPortResource;
use Modules\CommonModule\Traits\ImageHelperTrait;
use Modules\CommonModule\Transformers\PaginateResource;
use MongoDB\BSON\ObjectId;

class BrandService
{
    use ImageHelperTrait;

    private $brandRepository;

    public function __construct(BrandRepository $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    public function findAllForDashboard(Request $request, $onlyActive = true)
    {
        $wheres = [];
        if ($onlyActive) {
            $wheres['is_active'] = true;
        }
        $brands = $this->brandRepository->listOfBrandsForDashboard($request, $wheres);

        if ($brands instanceof LengthAwarePaginator) {
            return new PaginateResource(BrandResource::collection($brands));
        }

        return BrandResource::collection($brands);
    }

    public function find($brandId)
    {
        $brand = $this->brandRepository->find($brandId);

        return new FindBrandResource($brand);
    }

    public function create(CreateBrandRequest $createBrandRequest)
    {
        $brand = $this->brandRepository->create([
            'name'       => $createBrandRequest->name,
            'logo'       => $this->uploadImage('brands', $createBrandRequest->logo),
            'is_active'  => ($createBrandRequest->is_active === null) || (boolean)$createBrandRequest->is_active
        ]);

        return [
            'id'        => $brand->id
        ];
    }

    public function update($id, UpdateBrandRequest $updateBrandRequest)
    {
        $data = [
            'name'       => $updateBrandRequest->name,
            'is_active'  => ($updateBrandRequest->is_active === null) || (boolean)$updateBrandRequest->is_active
        ];

        if ($updateBrandRequest->hasFile('logo')) {
            $data['logo'] = $this->uploadImage('brands', $updateBrandRequest->logo);
        }

        $brand = $this->brandRepository->update($id, $data);

        return [
            'id'    => $brand->id
        ];
    }

    public function delete($id)
    {
        return $this->brandRepository->destroy($id);
    }
}
