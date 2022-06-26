<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class AlphaNumSpacesRule implements Rule
{
    private $languageCode;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($languageCode = null)
    {
        $this->languageCode = $languageCode;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $languagesPattern = [
            'ar'            => '/^[\p{Arabic}\s\p{N}]+$/mu',
            'en'            => '/^[A-Za-z0-9 _]*[A-Za-z0-9][A-Za-z0-9 _]*$/'
        ];

        if (!$this->languageCode) {
            return preg_match('/^[\pL\s0-9]+$/u', $value);
        }

        if (!isset($languagesPattern[$this->languageCode])) {
            return false;
        }

        return preg_match($languagesPattern[$this->languageCode], $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $languages = ['ar' => 'Arabic', 'en' => 'English'];

        if ($language = @$languages[$this->languageCode]) {
            return sprintf('The :attribute must only contain %s letters and numbers', $language);
        }

        return 'The :attribute must only contain letters and numbers';
    }
}
