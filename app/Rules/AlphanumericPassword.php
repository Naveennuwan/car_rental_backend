<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class AlphanumericPassword implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Check if the value contains 8 to 16 and contain both alphabets and numbers.
        // return preg_match('/^[a-zA-Z0-9]{8,16}$/', $value);

        // Check if the value contains 8 to 16 characters
        // and includes both alphabets and numbers
        return preg_match('/^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z\d]{8,16}$/', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        // return 'Please use 8 to 16 and includes both alphabets and numbers.';
        return '※8～16文字の半角英数字で入力してください。';
    }
}
