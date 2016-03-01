<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('index');
});


/* Help Me section routes */
Route::get('/locate', 'HelpController@location');
Route::get('/helpme', 'HelpController@index');
Route::get('/message', 'HelpController@message');
Route::post('/details', 'HelpController@details');
Route::post('/testing', 'HelpController@display');
Route::get('/test', 'HelpController@test');
/* Help Me section routes */


/*People stuck routes*/

/*People stuck routes*/