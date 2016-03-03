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

Route::get('/', 'HelpController@home');


/* Help Me section routes */
Route::get('/locate', 'HelpController@location');
Route::get('/helpme', 'HelpController@index');
Route::post('/message', 'HelpController@message');
Route::post('/details', 'HelpController@details');
Route::get('/find', 'HelpController@find');
Route::get('/weather', 'HelpController@weather');
Route::get('/camps', 'HelpController@camps');
Route::get('/donate', 'HelpController@donate');
Route::post('/submit', 'HelpController@submit');

Route::get('/login', 'AgencyController@display');
Route::post('/validate', 'AgencyController@validation');
Route::get('/agency_home', 'AgencyController@index');
Route::get('/agency/logout', 'AgencyController@logout');
Route::get('/add_camp', 'AgencyController@add');
Route::post('/relief', 'AgencyController@addCamp');
Route::get('/alerts', 'AgencyController@alerts');
/* Help Me section routes */


/*People stuck routes*/

/*People stuck routes*/