<?php
/**
 * Created by PhpStorm.
 * User: ahmed hasssan
 */

namespace Modules\CommonModule\Services;

class CurrencyService
{
    public function getCurrenciesCode()
    {
        return array_keys(currencies());
    }
}
