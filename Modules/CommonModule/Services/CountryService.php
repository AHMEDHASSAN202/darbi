<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CommonModule\Services;

use Illuminate\Http\Request;
use Modules\CommonModule\Repositories\CountryRepository;
use Modules\CommonModule\Transformers\CountryResource;

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

        return CountryResource::collection($countries);
    }
}
