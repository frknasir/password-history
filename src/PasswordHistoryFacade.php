<?php

namespace Starfolksoftware\PasswordHistory;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Starfolksoftware\PasswordHistory\PasswordHistory
 */
class PasswordHistoryFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'password-history';
    }
}
