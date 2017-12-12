<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class TranscriptionRule implements Rule
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
        return preg_match_all('/(^(#D)?[А-Яа-яЁёӨөҮү \.\*!\?,\.\(\)~\$%#<>GN-]{1,255}$)/u', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.transcription');
    }
}
