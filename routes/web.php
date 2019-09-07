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

/* View tables */

Route::get('/roles', function () {
    $roles = DB::table('roles')->get();
    return view('roles', ['roles' => $roles]);
})->name('roles');

Route::resource('users','UserController');


Route::get('/new-role', function () {
    return view('registerRole');
})->name('new-role');

Route::get('/register-company', function () {
    return view('registerCompany');
});

/* Routes for register datas */
Route::post('/register-company', 'CompanyController@submit');
Route::post('/new-role', 'RoleController@submit');
