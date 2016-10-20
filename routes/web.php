<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
/*----------------------------AUTH---------------------------*/

Auth::routes();

Route::get('/logout', function(){
    Auth::logout();
    return View::make('auth.login');
});

/*----------------------------Dashboard----------------------*/
//fixed routes go first
Route::resource('projects', 'ProjectController');

Route::resource('page', 'PageController');

Route::get('/admin/invoice', 'AdminController@invoice');
Route::post('/admin/invoice', 'AdminController@invoicePrint')->middleware('view.parse');


/*----------------------------Public pages--------------------*/
//if fixed routes don't exist, try routes generated through the cms
Route::get('/{url}/{sub?}/{edit?}', 'PageController@show')->name('page.show');
Route::post('/{url}/{sub?}', 'PageController@update')->middleware('view.parse');