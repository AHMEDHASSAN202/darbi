<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\AuthModule\Repositories\User;

use Illuminate\Http\Request;
use Modules\AuthModule\Entities\SavedPlace;

class SavedUserRepository
{
    private $model;

    public function __construct(SavedPlace $model)
    {
        $this->model = $model;
    }

    public function listPlacesByUserId($userId, $limit = 10)
    {
        return $this->model->where('user_id', $userId)->with('region')->latest()->limit($limit)->get();
    }

    public function create($data)
    {
        return $this->model->create($data);
    }
}
