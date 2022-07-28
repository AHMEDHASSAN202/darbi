<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CommonModule\Services;

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

    public function countries(Request $request)
    {
        $countries = $this->countryRepository->list($request);

        if ($countries instanceof LengthAwarePaginator) {
            return successResponse(['countries' => new PaginateResource(CountryResource::collection($countries))]);
        }

        return successResponse(['countries' => CountryResource::collection($countries)]);
    }
}
