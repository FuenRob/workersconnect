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
/* Roles views */
Route::resource('roles','RoleController');
/* Groups views */
Route::resource('groups','GroupController');
/* Teams views */
Route::resource('teams','TeamController');

Route::get('/register-company', function () {
    return view('registerCompany');
})->name('register-company');

/* Routes for register datas */
Route::post('/register-company', 'CompanyController@submit');
