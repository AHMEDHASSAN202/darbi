<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CommonModule\Services\Admin;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\CommonModule\Repositories\CountryRepository;
use Modules\CommonModule\Transformers\CountryResource;
use Modules\CommonModule\Transformers\PaginateResource;

class CountryService
{
    private $countryRepository;

    public function __construct(CountryRepository $countryRepository)
    {
        $this->countryRepository = $countryRepository;
    }

    public function findAll(Request $request)
    {
        $countries = $this->countryRepository->findAllForDashboard($request);

        if ($countries instanceof LengthAwarePaginator) {
            return successResponse(['countries' => new PaginateResource(CountryResource::collection($countries))]);
        }

        return successResponse(['countries' => CountryResource::collection($countries)]);
    }

    public function toggleActive($countryId)
    {
        $country = $this->countryRepository->toggleActive($countryId);

        return updatedResponse(['id' => $country->id]);
    }

    public function find($countryId)
    {
        $country = $this->countryRepository->findForDashboard($countryId);

        return successResponse(['country' => new CountryResource($country)]);
    }
}
