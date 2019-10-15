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
//name es el nombre de la ruta
Route::get('/', function () {
    return view('welcome');
});
Route::get('/usuarios','UserController@index')->name('users.index');

////Route::get('/usuarios/{user}','UserController@show');
//        ->where('user','[0-9]+')
//        ->name('user.details');
Route::get('/usuarios/{id}','UserController@show')
        ->where('id','[0-9]+')
       ->name('users.details');

Route::get('/usuarios/crear', 'UserController@create')->name('users.create');
//Route::get('/usuarios/crear', 'ProfessionController@show')->name('users.create');

Route::post('/usuarios/guardar','UserController@store')->name('users.store');


Route::get('/usuarios/{user}/editar', 'UserController@edit')->name('users.edit');
Route::put('/usuarios/{user}','UserController@update')->name('users.detail');
Route::delete('/usuarios/{user}','UserController@destroy')->name('borrar');

Route::get('/saludo/{name}/{nickname?}', 'WelcomeUserController@index')->name('users.welcome');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
