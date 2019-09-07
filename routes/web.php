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

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/users', function () {
    $users = DB::table('users')->get();
    $roles = DB::table('roles')->get();
    return view('users', ['users' => $users, 'roles' => $roles]);
})->name('users');

Route::get('/new-user', function () {
    $roles = DB::table('roles')->get();
    $user = Auth::user();
    return view('registerUser', ['roles' => $roles, 'user' => $user]);
})->name('new-user');

Route::get('/roles', function () {
    $roles = DB::table('roles')->get();
    return view('roles', ['roles' => $roles]);
})->name('roles');

Route::get('/new-role', function () {
    return view('registerRole');
})->name('new-role');

Route::get('/register-company', function () {
    return view('registerCompany');
});

Route::post('/register-company', 'CompanyController@submit');
Route::post('/new-role', 'RoleController@submit');
Route::post('/new-user', 'UserController@submit');
