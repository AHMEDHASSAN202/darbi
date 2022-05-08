<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CommonModule\Services;

class CommonService
{
    private $assets;

    public function __construct()
    {
        $this->assets = assetsHelper();
    }

    public function countries()
    {
        return $this->assets->countries();
    }

    public function country($iso)
    {
        $country = $this->assets->country($iso);

        abort_if(empty($country['iso']), 404);

        return $country;
    }
}
