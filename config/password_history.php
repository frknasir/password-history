<?php

return [
    /**
     * The table name for password histories.
     */
    'table_name' => 'password_histories',

    /**
     * Password change can not be the same with any password in the last 
     * {{ password_history_check_length }} recent passwords
     */
    'password_history_check_length' => env('PASSWORD_HISTORY_CHECK_LENGTH', 5),

    /*
    * The user model that should be used. If null, the default user provider from your
    * Laravel authentication configuration will be used.
    */
    'user_model' => \Illuminate\Foundation\Auth\User::class,
];
