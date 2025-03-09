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
    Route::post('/users/add', 'App\Http\Controllers\Users@add');
    Route::post('/users/checkUniqueEmail', 'App\Http\Controllers\Users@checkUniqueEmail');
    Route::post('/users/filter', 'App\Http\Controllers\Users@filter');
    Route::get('/users/edit/{id}', 'App\Http\Controllers\Users@edit')->name('user.edit');
    Route::post('/users/updateStatus', 'App\Http\Controllers\Users@updateStatus');
    Route::post('/users/delete/{id}', 'App\Http\Controllers\Users@delete')->name('user.delete');

    // setting route
    Route::get('/settings', 'App\Http\Controllers\Settings@index');
    Route::post('/settings/add', 'App\Http\Controllers\Settings@add');

    // login history route
    Route::get('/login-history', 'App\Http\Controllers\Login_history@index');
    Route::post('/login-history/filter', 'App\Http\Controllers\Login_history@filter');

});

Route::post('login/checkLogin', 'App\Http\Controllers\Login@checkLogin');
Route::get('logout', 'App\Http\Controllers\Dashbord@logout');