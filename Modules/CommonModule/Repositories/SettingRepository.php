<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CommonModule\Repositories;

use Modules\CommonModule\Entities\Setting;

class SettingRepository
{
    private $model;

    public function __construct(Setting $model)
    {
        $this->model = $model;
    }

    public function updateSetting($data, $key)
    {
        $option = Setting::findOrFail($key);
        $option->value = $data['value'];
        $option->save();

        return $option;
    }

    public function list()
    {
        return $this->model->get();
    }
}
