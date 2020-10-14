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
];
