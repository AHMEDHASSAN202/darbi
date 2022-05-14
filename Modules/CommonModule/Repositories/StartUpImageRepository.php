<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CommonModule\Repositories;

use Illuminate\Support\Facades\Log;
use Jenssegers\Mongodb\Eloquent\Model;
use Modules\CommonModule\Entities\Activity;
use Modules\CommonModule\Entities\StartUpImage;

class StartUpImageRepository
{
    private $model;

    public function __construct(StartUpImage $model)
    {
        $this->model = $model;
    }

    public function list($limit = 3)
    {
        return $this->model->active()->valid()->limit($limit ?? 3)->get();
    }
}
