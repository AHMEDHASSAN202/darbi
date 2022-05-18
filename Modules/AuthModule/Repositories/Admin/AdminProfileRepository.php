<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\AuthModule\Repositories\Admin;

use Modules\AuthModule\Entities\Admin;

class AdminProfileRepository
{
    private $model;

    public function __construct(Admin $model)
    {
        $this->model = $model;
    }
}
