<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Services;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\CatalogModule\Http\Requests\Admin\CreateExtraRequest;
use Modules\CatalogModule\Http\Requests\Admin\UpdateExtraRequest;
use Modules\CatalogModule\Repositories\ExtraRepository;
use Modules\CatalogModule\Transformers\ExtraResource;
use Modules\CommonModule\Transformers\PaginateResource;
use MongoDB\BSON\ObjectId;

class ExtraService
{
    private $extraRepository;

    public function __construct(ExtraRepository $extraRepository)
    {
        $this->extraRepository = $extraRepository;
    }

    public function list(Request $request)
    {
        $paginated = $request->has('paginated');
        $limit = $request->get('limit', 20);

        $extras = $this->extraRepository->listWithPlugin($request, $paginated ? $limit : null);

        if ($extras instanceof LengthAwarePaginator) {
            return new PaginateResource(ExtraResource::collection($extras));
        }

        return ExtraResource::collection($extras);
    }

    public function create(CreateExtraRequest $createExtraRequest)
    {
        $plugin = $this->extraRepository->create([
            'vendor_id'     => new ObjectId(getVendorId()),
            'plugin_id'     => new ObjectId($createExtraRequest->plugin_id),
            'price'         => $createExtraRequest->price
        ]);

        return [
            'id'        => $plugin->id
        ];
    }

    public function update($id, UpdateExtraRequest $updateExtraRequest)
    {
        $plugin = $this->extraRepository->update($id, [
            'vendor_id'     => new ObjectId(getVendorId()),
            'plugin_id'     => new ObjectId($updateExtraRequest->plugin_id),
            'price'         => $updateExtraRequest->price
        ]);

        return [
            'id'        => $plugin->id
        ];
    }

    public function delete($id)
    {
        return $this->extraRepository->destroy($id);
    }
}
