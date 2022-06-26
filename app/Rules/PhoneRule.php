<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PhoneRule implements Rule
{
    private $phoneCode;


    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($phoneCode)
    {
        $this->phoneCode = $phoneCode;
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
        $phoneRegex = [
            "971"   => '/^(?:0)(?:2|3|4|6|7|9|50|51|52|55|56)[0-9]{7}$/',
            "966"   => '/^(05|5)(5|0|3|6|4|9|1|8|7)([0-9]{7})$/'
        ];

        if (!isset($phoneRegex[$this->phoneCode])) {
            return false;
        }

        if (!preg_match($phoneRegex[$this->phoneCode], $value)) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Not a valid phone number (must not include spaces, country code or special characters)';
    }
}
