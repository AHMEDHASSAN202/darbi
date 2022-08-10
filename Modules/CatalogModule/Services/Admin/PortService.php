<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Services\Admin;

use App\Proxy\Proxy;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\CatalogModule\Http\Requests\Admin\CreatePortRequest;
use Modules\CatalogModule\Http\Requests\Admin\UpdatePortRequest;
use Modules\CatalogModule\Proxy\CatalogProxy;
use Modules\CatalogModule\Repositories\PortRepository;
use Modules\CatalogModule\Transformers\Admin\FindPortResource;
use Modules\CatalogModule\Transformers\Admin\PortResource;
use Modules\CommonModule\Transformers\PaginateResource;
use MongoDB\BSON\ObjectId;

class PortService
{
    private $portRepository;

    public function __construct(PortRepository $portRepository)
    {
        $this->portRepository = $portRepository;
    }

    public function findAllForDashboard(Request $request, $onlyActive = true)
    {
        $wheres = [];
        if ($onlyActive) {
            $wheres['is_active'] = true;
        }

        $ports = $this->portRepository->listOfPortsForDashboard($request, $wheres);

        if ($ports instanceof LengthAwarePaginator) {
            return new PaginateResource(PortResource::collection($ports));
        }

        return PortResource::collection($ports);
    }

    public function find($portId)
    {
        $port = $this->portRepository->findOne($portId);

        return new \Modules\CatalogModule\Transformers\PortResource($port);
    }

    public function create(CreatePortRequest $createPortRequest)
    {
        $port = $this->portRepository->create([
            'name'       => $createPortRequest->name,
            'country_id' => new ObjectId($createPortRequest->country_id),
            'city_id'    => new ObjectId($createPortRequest->city_id),
            'lat'        => $createPortRequest->lat,
            'lng'        => $createPortRequest->lng,
            'is_active'  => ($createPortRequest->is_active === null) || (boolean)$createPortRequest->is_active,
            'fully_addressed' => $this->getFullyAddressed($createPortRequest->lat, $createPortRequest->lng)
        ]);

        return createdResponse(['id' => $port->id]);
    }

    public function update($id, UpdatePortRequest $updatePortRequest)
    {
        $port = $this->portRepository->update($id, [
            'name'       => $updatePortRequest->name,
            'country_id' => new ObjectId($updatePortRequest->country_id),
            'city_id'    => new ObjectId($updatePortRequest->city_id),
            'lat'        => $updatePortRequest->lat,
            'lng'        => $updatePortRequest->lng,
            'is_active'  => ($updatePortRequest->is_active === null) || (boolean)$updatePortRequest->is_active,
            'fully_addressed' => $this->getFullyAddressed($updatePortRequest->lat, $updatePortRequest->lng)
        ]);

        return updatedResponse(['id' => $port->id]);
    }

    public function delete($id)
    {
        $this->portRepository->destroy($id);

        return deletedResponse();
    }

    private function getFullyAddressed($lat, $lng)
    {
        $location = (new Proxy(new CatalogProxy('GET_LOCATION', ['lat' => $lat, 'lng' => $lng])))->result();

        return arrayGet($location, 'fully_addressed');
    }
}
