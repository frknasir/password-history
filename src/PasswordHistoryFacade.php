<?php

namespace StarfolkSoftware\PasswordHistory;

use Illuminate\Support\Facades\Facade;

/**
 * @see \StarfolkSoftware\PasswordHistory\PasswordHistory
 */
class PasswordHistoryFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'password-history';
    }
}
