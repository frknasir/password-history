<?php
namespace StarfolkSoftware\PasswordHistory\Tests\Models;

use StarfolkSoftware\PasswordHistory\Traits\HasPasswordHistory;
use Illuminate\Database\Eloquent\Model;

class AdminUser extends Model {
    use HasPasswordHistory;
    
    protected $table = 'admin_users';

    protected $fillable = [
        'name',
        'email',
        'password'
    ];
}
