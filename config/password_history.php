<?php

return [
    /*
    * When using the "HasPasswordHistory" trait from this package, we need to know which
    * Eloquent model should be used to retrieve your roles. Of course, it
    * is often just the "PasswordHistory" model but you may use whatever you like.
    *
    * The model you want to use as a PasswordHistory model needs to implement the
    * `StarfolkSoftware\PasswordHistory\Contracts\PasswordHistory` contract.
    */
    'password_history_class' => \StarfolkSoftware\PasswordHistory\PasswordHistory::class,

    /**
     * The table name for password histories.
     */
    'table_name' => 'password_histories',

    /**
     * The models password column name
     */
    'models_password_column_name' => 'password',

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
