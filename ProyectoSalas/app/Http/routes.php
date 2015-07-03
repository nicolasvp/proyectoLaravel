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
/*

*/

//Route::get('home', 'HomeController@index');

Route::controller('Administrador','AdministradorController');

Route::controller('Encargado','EncargadoController');

Route::controller('Alumno','AlumnoController');

Route::controller('Docente','DocenteController');



Route::controller('/','loginController');
Route::controller('/login','loginController');


Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
