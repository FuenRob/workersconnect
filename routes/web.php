<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

/* Dashboard */
Route::get('/home', 'HomeController@index')->name('home');
/* Users views */
Route::resource('users','UserController');
Route::get('get-users', 'UserController@getUsers');
/* Roles views */
Route::resource('roles','RoleController');
/* Teams views */
Route::resource('teams','TeamController');
/* Groups views */
Route::resource('groups','GroupController');
Route::get('/follow-group/{id}', 'GroupController@followGroup')->where('id', '[0-9]+');
Route::get('/unfollow-group/{id}', 'GroupController@unfollowGroup')->where('id', '[0-9]+');

/* Teams Holidays views */
Route::resource('holidays','TeamsHolidaysController');
Route::get('/holiday/accept/{id}', 'TeamsHolidaysController@accept')->where('id', '[0-9]+');
Route::get('/holiday/decline/{id}', 'TeamsHolidaysController@decline')->where('id', '[0-9]+');

Route::get('/register-company', function () {
    return view('registerCompany');
})->name('register-company');

/* Routes for register datas */
Route::post('/register-company', 'CompanyController@submit');
