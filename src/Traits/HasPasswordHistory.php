<?php

namespace StarfolkSoftware\PasswordHistory\Traits;

use Illuminate\Database\Eloquent\Relations\HasMany;
use StarfolkSoftware\PasswordHistory\PasswordHistory;

trait HasPasswordHistory
{
    public static function bootHasPasswordHistory()
    {
        static::saved(function ($model) {
            PasswordHistory::create([
                'user_id' => $model->id,
                'password' => $model->password,
            ]);
        });
    }

    public function previousPasswords(): HasMany
    {
        return $this->hasMany(PasswordHistory::class, 'user_id');
    }
}
