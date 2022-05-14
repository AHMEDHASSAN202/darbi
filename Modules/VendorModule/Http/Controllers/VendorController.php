<?php

namespace Modules\VendorModule\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CommonModule\Traits\ApiResponseTrait;
use Modules\VendorModule\Http\Requests\CreateUserRequest;
use Modules\VendorModule\Http\Requests\UpdateUserRequest;
use Modules\VendorModule\Services\VendorService;

/**
 * @group Vendors
 *
 * Management Vendors
 */
class VendorController extends Controller
{
    use ApiResponseTrait;

    private $vendorService;

    public function __construct(VendorService $vendorService)
    {
        $this->vendorService = $vendorService;
    }

    /**
     * List of vendors
     *
     * @queryParam q string
     * get vendors. If everything is okay, you'll get a 200 OK response.
     * Otherwise, the request will fail with a 400 || 422 || 500 error
     */
    public function index(Request $request)
    {
        $vendors = $this->vendorService->list($request);

        return $this->apiResponse(compact('vendors'));
    }

    /**
     * Create Vendor
     *
     * @bodyParam name string required
     * @bodyParam email string required
     * @bodyParam password string required
     * @bodyParam phone string required
     * @bodyParam image file optional.
     * @bodyParam country string optional. country code [2 chars]
     * @bodyParam city string optional. country code [2 chars]
     * create new vendor. If everything is okay, you'll get a 200 OK response.
     * Otherwise, the request will fail with a 400 || 422 || 500 error
     */
    public function store(CreateUserRequest $createVendorRequest)
    {
        $vendor = $this->vendorService->create($createVendorRequest);

        return $this->apiResponse(compact('vendor'), 201, __('Data has been added successfully'));
    }

    /**
     * Update Vendor
     *
     * @param $id
     * @param UpdateUserRequest $updateVendorRequeste
     * @bodyParam name string required
     * @bodyParam email string required
     * @bodyParam password string required
     * @bodyParam phone string required
     * @bodyParam image file optional.
     * @bodyParam country string optional. country code [2 chars]
     * @bodyParam city string optional. country code [2 chars]
     * update vendor. If everything is okay, you'll get a 200 OK response.
     * Otherwise, the request will fail with a 400 || 422 || 500 error
     */
    public function update($id, UpdateUserRequest $updateVendorRequest)
    {
        $vendor = $this->vendorService->update($id, $updateVendorRequest);

        return $this->apiResponse(compact('vendor'), 200, __('Data has been updated successfully'));
    }

    /**
     * Delete Vendor
     *
     * @param $id
     * delete vendor. If everything is okay, you'll get a 200 OK response.
     * Otherwise, the request will fail with a 400 || 422 || 500 error
     */
    public function destroy($id)
    {
        $this->vendorService->destroy($id);

        return $this->apiResponse([], 200, __('Data has been deleted successfully'));
    }
}
