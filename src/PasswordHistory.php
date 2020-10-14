<?php

namespace StarfolkSoftware\PasswordHistory;

use Illuminate\Database\Eloquent\{Model};

class PasswordHistory extends Model {
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'views';

    protected $fillable = ['user_id','password', 'guard'];
}
