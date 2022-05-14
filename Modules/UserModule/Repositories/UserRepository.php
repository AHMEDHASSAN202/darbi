<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\UserModule\Repositories;

use Modules\CommonModule\Traits\CrudRepositoryTrait;
use Modules\UserModule\Entities\User;

class UserRepository
{
    use CrudRepositoryTrait;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function listOfUsers($limit = 20)
    {
        return $this->list($limit, 'adminSearch');
    }
}
