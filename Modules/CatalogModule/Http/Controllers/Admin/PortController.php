<?php

namespace Modules\CatalogModule\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CatalogModule\Http\Requests\Admin\CreatePortRequest;
use Modules\CatalogModule\Http\Requests\Admin\UpdatePortRequest;
use Modules\CatalogModule\Services\Admin\PortService;
use Modules\CommonModule\Traits\ApiResponseTrait;

class PortController extends Controller
{
    use ApiResponseTrait;

    private $portService;

    public function __construct(PortService $portService)
    {
        $this->portService = $portService;
    }

    public function index(Request $request)
    {
        $ports = $this->portService->findAllForDashboard($request, false);

        return $this->apiResponse(compact('ports'));
    }

    public function show($portId)
    {
        return $this->apiResponse([
            'port'      => $this->portService->find($portId)
        ]);
    }

    public function store(CreatePortRequest $createPortRequest)
    {
        $result = $this->portService->create($createPortRequest);

        return $this->apiResponse(...$result);
    }

    public function update($id, UpdatePortRequest $updatePortRequest)
    {
        $result = $this->portService->update($id, $updatePortRequest);

        return $this->apiResponse(...$result);
    }

    public function destroy($id)
    {
        $result = $this->portService->delete($id);

        return $this->apiResponse(...$result);
    }
}
