<?php

return [
    /**
     * User model class name.
     */
    //'userModel' => env('USER_MODEL', file_exists('..\App\Models') ? 'App\Models\User' : 'App\User'),
    'userModel' => env('USER_MODEL', 'App\Models\User'),

    /**
     * Configure Brandenburg to not register its migrations.
     */
    'ignoreMigrations' => false,
];
