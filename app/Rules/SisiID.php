<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class SisiID implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        return preg_match_all('(^[0-9]{2}[A-Za-z]{1}[0-9]{1}[A-Za-z]{2,4}[0-9]{4}$)', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.sisiid');
    }
}
