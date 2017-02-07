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

Route::get('/', array('middleware' => array('auth'), 'uses' => 'BaseController@index'));


Route::get('login', function () {
    return view('layouts.login');
});

Route::post('login', array('as' => 'login.attemp', 'uses' => 'LoginController@authenticate'));

Route::get('salir', 'Auth\AuthController@getLogout');
