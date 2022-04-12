<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CommonModule\Traits;

trait AddIdModelPropertyTrait
{
    public function getIdAttribute()
    {
        return $this->_id;
    }
}
