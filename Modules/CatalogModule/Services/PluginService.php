<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Services;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\CatalogModule\Http\Requests\Admin\CreatePluginRequest;
use Modules\CatalogModule\Http\Requests\Admin\UpdatePluginRequest;
use Modules\CatalogModule\Repositories\PluginRepository;
use Modules\CatalogModule\Transformers\Admin\PluginEditResource;
use Modules\CatalogModule\Transformers\PluginResource;
use Modules\CommonModule\Transformers\PaginateResource;

class PluginService
{
    private $pluginRepository;

    public function __construct(PluginRepository $pluginRepository)
    {
        $this->pluginRepository = $pluginRepository;
    }

    public function findAllPlugin($entityId)
    {
        $plugins = $this->pluginRepository->findAllPlugin($entityId);

        return PluginResource::collection($plugins);
    }

    public function create(CreatePluginRequest $createPluginRequest)
    {
        $plugin = $this->pluginRepository->create([
            'name'          => $createPluginRequest->name,
            'desc'          => $createPluginRequest->desc,
            'is_active'     => ($createPluginRequest->is_active === null) || (boolean)$createPluginRequest->is_active
        ]);

        return [
            'id'       => $plugin->id
        ];
    }

    public function update($id, UpdatePluginRequest $updatePluginRequest)
    {
        $plugin = $this->pluginRepository->update($id, [
            'name'          => $updatePluginRequest->name,
            'desc'          => $updatePluginRequest->desc,
            'is_active'     => ($updatePluginRequest->is_active === null) || (boolean)$updatePluginRequest->is_active
        ]);

        return [
            'id'        => $plugin->id
        ];
    }

    public function delete($id)
    {
        return $this->pluginRepository->destroy($id);
    }

    public function list(Request $request, $onlyActive = true)
    {
        $paginated = $request->has('paginated');
        $limit = $request->get('limit', 20);

        $plugins = $this->pluginRepository->list($paginated ? $limit : null, 'filters', $onlyActive ? 'active' : '');

        if ($plugins instanceof LengthAwarePaginator) {
            return new PaginateResource(PluginResource::collection($plugins));
        }

        return PluginResource::collection($plugins);
    }

    public function find($id)
    {
        $plugin = $this->pluginRepository->find($id);

        return new PluginEditResource($plugin);
    }
}
