<?php

namespace StarfolkSoftware\PasswordHistory\Contracts;

use Illuminate\Database\Eloquent\Relations\{MorphTo, BelongsTo};

interface PasswordHistory
{
    public function passwordhistorable(): MorphTo;

    public function historian(): BelongsTo;
}
