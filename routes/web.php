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
Route::get('/usuarios','UserController@index')->name('users.index');

//Route::get('/usuarios/{user}','UserController@show')
//        ->where('user','[0-9]+')
//        ->name('user.details');
Route::get('/usuarios/{id}','UserController@show')
        ->where('id','[0-9]+')
        ->name('users.details');

Route::get('/usuarios/nuevo', 'UserController@create')->name('users.new');
Route::post('/usuarios/crear','UserController@store')->name('users.store');

Route::get('/saludo/{name}/{nickname?}', 'WelcomeUserController@index')->name('users.welcome');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
