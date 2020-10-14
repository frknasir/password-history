<?php

namespace StarfolkSoftware\PasswordHistory\Rules;

use Auth;
use Illuminate\Contracts\Validation\Rule;

class NotInRecentPasswordHistory implements Rule
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
        //get the last 5 password history of the loggedin user
        $prevPasswords = Auth::user()->previousPasswords()->take(5);

        //loop through and make sure none is the same with the
        //has of the will-be password
        $passwordCollection = collect($prevPasswords);
        
        return ! ($passwordCollection->contains(function ($val, $key) use ($value) {
            return $key == 'password' && $val == $value;
        }));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must not be the same with recent passwords';
    }
}
