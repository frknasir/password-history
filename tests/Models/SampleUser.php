<?php
namespace StarfolkSoftware\PasswordHistory\Tests\Models;

use Illuminate\Foundation\Auth\User;
use StarfolkSoftware\PasswordHistory\Traits\HasPasswordHistory;

class SampleUser extends User
{
    use HasPasswordHistory;
    
    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];
}
