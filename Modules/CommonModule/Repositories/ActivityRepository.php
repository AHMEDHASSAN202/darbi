<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CommonModule\Repositories;

use Illuminate\Support\Facades\Log;
use Jenssegers\Mongodb\Eloquent\Model;
use Modules\CommonModule\Entities\Activity;

class ActivityRepository
{
    private $model;

    public function __construct(Activity $model)
    {
        $this->model = $model;
    }

    public function log($log_name, Model $model, $description = null, $properties = [])
    {
        $meGuard = getCurrentGuard();
        $me = auth($meGuard)->user();

        if (!$meGuard) {
            Log::error("activity log can't get current user guard");
            return;
        }

        $changes = [];
        foreach($model->getDirty() as $key => $value) {
            $preventActivityLog = ($model->preventActivityLog ?? []) + ['updated_at'];
            if (!in_array($key, $preventActivityLog)) {
                $original = $model->getOriginal($key);
                $changes[$key] = ['old' => $original, 'new' => $value];
            }
        }

        return $this->model->create([
            'causer_id'     => $me->id,
            'causer_type'   => get_class($me),
            'log_name'      => $log_name,
            'model'         => $model::class,
            'description'   => $description,
            'changes'       => $changes,
            'properties'    => $properties
        ]);
    }

    public function getActivities($causerId, $causerType, $paginate = 20)
    {
        return $this->model->where('causer_id', $causerId)->where('causer_type', $causerType)->latest()->paginate($paginate);
    }
}
