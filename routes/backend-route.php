<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'App\Http\Controllers\Login@index');

if(config('constants.ONLY_ADMIN_PANEL') != false){
    Route::get('login', 'App\Http\Controllers\Login@index');
}

Route::group(['middleware' => ['checklogin'], 'prefix' => config('constants.BACKEND_ROUTE_SLUG')], function () {

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
    
    // invoce route
    Route::get('/invoice', 'App\Http\Controllers\InvoiceController@index');
    Route::get('/invoice/create', 'App\Http\Controllers\InvoiceController@create');
    Route::post('/invoice/add', 'App\Http\Controllers\InvoiceController@add');
    Route::post('/invoice/filter', 'App\Http\Controllers\InvoiceController@filter');
    Route::get('/invoice/edit/{id}', 'App\Http\Controllers\InvoiceController@edit')->name('invoice.edit');
    Route::post('/invoice/updateStatus', 'App\Http\Controllers\InvoiceController@updateStatus');
    Route::post('/invoice/delete/{id}', 'App\Http\Controllers\InvoiceController@delete');
    Route::get('/invoice/exportPdf/{id}', 'App\Http\Controllers\InvoiceController@exportPdf')->name('invoice.exportPdf');

    // profile route
    Route::get('/profile/edit/{id}', 'App\Http\Controllers\ProfileController@edit');
    Route::post('/profile/add', 'App\Http\Controllers\ProfileController@add');
});

Route::post('login/checkLogin', 'App\Http\Controllers\Login@checkLogin');
Route::get('logout', 'App\Http\Controllers\Dashbord@logout');