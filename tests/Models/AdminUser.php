<?php
namespace StarfolkSoftware\PasswordHistory\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use StarfolkSoftware\PasswordHistory\Traits\HasPasswordHistory;

class AdminUser extends Model
{
    use HasPasswordHistory;
    
    protected $table = 'admin_users';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];
}
