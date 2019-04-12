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

Route::get('/','HomeController@index');

Route::get('/login','MainController@login');
Route::post('/login','MainController@validateLogin');
Route::get('logout',function(){
    \Illuminate\Support\Facades\Session::flush();
    return redirect('/login');
});

Route::get('/register','MainController@register');
Route::post('/register','UserController@saveUser');

//Manage Chat
Route::get('/chat/{id}','ChatController@chat');
Route::post('/chat/send','ChatController@send');
Route::get('/chat/messages/{to}','ChatController@messages');
Route::get('/chat/load/{to}','ChatController@loadMessages');
Route::get('/chat/reply/{id}','ChatController@reply');

//Manage profiles
Route::get('/profile/{id}','HomeController@profile');


