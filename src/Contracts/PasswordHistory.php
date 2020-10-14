<?php

namespace StarfolkSoftware\PasswordHistory\Contracts;

use Illuminate\Database\Eloquent\Relations\{BelongsTo};

interface PasswordHistory
{
  public function owner(): BelongsTo;
}
