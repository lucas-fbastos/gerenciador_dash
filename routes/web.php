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

Route::get('/',  'Auth\LoginController@showLoginForm');

Auth::routes();
//links
Route::get('/home', 'LinkController@index')->name('links');
Route::get('/cadastroLinks', 'LinkController@create')->name('novoLink');
Route::post('/save.links', 'LinkController@store');
Route::get('/links/{id}', 'LinkController@edit');
Route::put('/links/{id}', 'LinkController@update');
Route::delete('/links/{id}', 'LinkController@destroy');
//users
Route::get('/users', 'UserController@index')->name('users')->middleware('verificarAdmin');
Route::get('/users/cadastro', 'UserController@create')->middleware('verificarAdmin');
Route::post('/users/cadastro', 'Usercontroller@store')->middleware('verificarAdmin');
Route::get('/users/{id}', 'Usercontroller@edit')->middleware('verificarAdmin');
Route::put('/users/{id}', 'Usercontroller@update')->middleware('verificarAdmin');
Route::post('/redefinir', 'Usercontroller@redefinir');
Route::delete('/users/{id}', 'UserController@destroy')->middleware('verificarAdmin');
Route::patch('/users/{id}', 'UserController@resetar')->middleware('verificarAdmin');