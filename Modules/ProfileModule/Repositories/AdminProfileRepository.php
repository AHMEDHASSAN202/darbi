<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\ProfileModule\Repositories;

use Modules\AdminModule\Entities\Admin;

class AdminProfileRepository
{
    private $model;

    public function __construct(Admin $model)
    {
        $this->model = $model;
    }
}
