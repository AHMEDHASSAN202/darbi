<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\AuthModule\Repositories\User;

use Illuminate\Http\Request;
use Modules\AuthModule\Entities\User;
use Modules\CommonModule\Traits\CrudRepositoryTrait;

class UserRepository
{
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function listOfUsers(Request $request, $limit = 20)
    {
        //
    }
}
