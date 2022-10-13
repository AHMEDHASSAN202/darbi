<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CommonModule\Repositories;

use Illuminate\Http\Request;
use Modules\CommonModule\Entities\CarType;

class CarTypeRepository
{
    private $model;

    public function __construct(CarType $model)
    {
        $this->model = $model;
    }

    public function list(Request $request)
    {
        return $this->model->search($request)->paginated();
    }
}
