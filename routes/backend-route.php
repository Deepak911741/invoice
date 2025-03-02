<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'App\Http\Controllers\Login@index');

if(config('constants.ONLY_ADMIN_PANEL') != false){
    Route::get('login', 'App\Http\Controllers\Login@index');
}