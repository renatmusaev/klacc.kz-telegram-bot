<?php

use Illuminate\Support\Facades\Route;

Route::post('telegram', 'App\Http\Controllers\TelegramController@index');