<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Cyrillic implements Rule
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
        return preg_match_all('/[А-Яа-яЁёӨөҮү ]+/', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.cyrillic');
//        return 'The :attribute must be cyrillic.';
    }
}
