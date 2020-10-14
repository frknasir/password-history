<?php

namespace StarfolkSoftware\PasswordHistory\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class NotInRecentPasswordHistory implements Rule
{
    protected Model $model;
    protected int $historyCheckLength;

    final public function __construct(Model $model)
    {
        $this->model = $model;
        $this->historyCheckLength = config('password_history.password_history_check_length');
    }

    public static function ofUser(Model $model): self
    {
        return new static($model);
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
        //get the last 5 password history of the loggedin user
        $prevPasswords = $this->model->previousPasswords()
            ->select('password')
            ->orderBy('created_at', 'desc')
            ->take($this->historyCheckLength)
            ->get();

        //loop through and make sure none is the same with the
        //has of the will-be password
        $passwordCollection = collect($prevPasswords);
        
        return ! ($passwordCollection->contains(function (array $val) use ($value): bool {
            return Hash::check($value, $val['password']);
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
