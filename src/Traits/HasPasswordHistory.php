<?php

namespace StarfolkSoftware\PasswordHistory\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{MorphMany};
use StarfolkSoftware\PasswordHistory\PasswordHistory;

trait HasPasswordHistory
{
    public static function bootHasPasswordHistory()
    {
        static::saved(function ($model) {
            $model->writePasswordHistory($model->password);
        });
    }

    public function previousPasswords(): MorphMany {
        return $this->morphMany(config('password_history.password_history_class'), 'passwordHistorable');
    }

    /**
     * Attach a password history to this model.
     *
     * @param string $password
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function writePasswordHistory(string $password)
    {
        return $this->writePasswordHistoryAsUser(auth()->user(), $password);
    }

    /**
     * Attach a password history to this model.
     * @param Model $user
     * @param string $password
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function writePasswordHistoryAsUser(?Model $user, string $password)
    {
        $passwordHistoryClass = config('password_history.password_history_class');

        $passwordHistory = new $passwordHistoryClass([
            'passwordhistorable_id' => $this->getKey(),
            'passwordhistorable_type' => get_class(),
            'user_id' => is_null($user) ? null : $user->getKey(),
            'password' => $password
        ]);

        return $this->previousPasswords()->save($passwordHistory);
    }
}
