<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CatalogModule\Services\Admin;

use App\Proxy\Proxy;
use Modules\CatalogModule\Http\Requests\Admin\CreateEntityRequest;
use Modules\CatalogModule\Http\Requests\Admin\UpdateEntityRequest;
use Modules\CatalogModule\Proxy\CatalogProxy;
use Modules\CatalogModule\Repositories\VillaRepository;
use Modules\CommonModule\Traits\ImageHelperTrait;
use MongoDB\BSON\ObjectId;

class VillaService
{
    use EntityHelperService, ImageHelperTrait;


    private $repository;
    private $uploadDirectory = 'villas';

    public function __construct(VillaRepository $villaRepository)
    {
        $this->repository = $villaRepository;
    }


    public function create(CreateEntityRequest $createEntityRequest)
    {
        $data = [
            'model_id'       => null,
            'brand_id'       => null,
            'city_id'        => new ObjectId($createEntityRequest->city_id),
            'location'       => $this->getLocation($createEntityRequest->lat, $createEntityRequest->lng)
        ];

        $villa = $this->createEntity($createEntityRequest, $data);

        return createdResponse(['id' => $villa->id]);
    }


    public function update($id, UpdateEntityRequest $updateEntityRequest)
    {
        $data = [
            'model_id'       => null,
            'brand_id'       => null,
            'city_id'        => new ObjectId($updateEntityRequest->city_id),
            'location'       => $this->getLocation($updateEntityRequest->lat, $updateEntityRequest->lng)
        ];

        $villa = $this->updateEntity($id, $updateEntityRequest, $data);

        return updatedResponse(['id' => $villa->id]);
    }


    private function getLocation($lat, $lng)
    {
        return (new Proxy(new CatalogProxy('GET_LOCATION', ['lat' => $lat, 'lng' => $lng])))->result() ?? ['location' => ['type' => 'Point', 'coordinates' => [(float)$lng, (float)$lat]]];
    }
}
