<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'App\Http\Controllers\Login@index');

if(config('constants.ONLY_ADMIN_PANEL') != false){
    Route::get('login', 'App\Http\Controllers\Login@index');
}

Route::group(['prefix' => config('constants.BACKEND_ROUTE_SLUG')], function(){

    Route::get('/', 'App\Http\Controllers\Dashbord@index');
    Route::get('/dashboard', 'App\Http\Controllers\Dashbord@index')->name('dashbord');

    //users route
    Route::get('/users', 'App\Http\Controllers\Users@index');
    Route::get('/users/create', 'App\Http\Controllers\Users@create');

});

Route::post('login/checkLogin', 'App\Http\Controllers\Login@checkLogin');
Route::get('logout', 'App\Http\Controllers\Dashbord@logout');