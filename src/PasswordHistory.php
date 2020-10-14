<?php

namespace StarfolkSoftware\PasswordHistory;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\{Model};
use StarfolkSoftware\PasswordHistory\Contracts\PasswordHistory as PasswordHistoryContract;

class PasswordHistory extends Model implements PasswordHistoryContract
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'password_histories';

    protected $fillable = ['user_id','password', 'guard'];

    public function owner(): BelongsTo
    {
        return $this->belongsTo($this->getAuthModelName(), 'user_id');
    }

    /**
     * get authentication model name
     *
     * @return String
     */
    protected function getAuthModelName(): String
    {
        if (config('password_history.user_model')) {
            return config('password_history.user_model');
        }

        if (! is_null(config('auth.providers.users.model'))) {
            return config('auth.providers.users.model');
        }

        throw new Exception('Could not determine the user model name.');
    }
}
