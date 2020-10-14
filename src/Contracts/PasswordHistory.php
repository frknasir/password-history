<?php

namespace StarfolkSoftware\PasswordHistory\Contracts;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

interface PasswordHistory
{
    public function passwordhistorable(): MorphTo;

    public function historian(): BelongsTo;
}
