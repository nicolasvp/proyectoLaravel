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


Route::get('Administrador/campus_list','AdministradorController@getCampus_list');

Route::get('Administrador/filed_list','AdministradorController@getFiled_list');

Route::post('Administrador/restore_campus','AdministradorController@postRestore_campus');

Route::delete('Administrador/deleteCampus','AdministradorController@deleteCampus');

Route::delete('Administrador/deleteProfile','AdministradorController@deleteRol');

Route::get('Administrador/search','AdministradorController@getSearch');

Route::post('Administrador/postProfile','AdministradorController@postProfile');

Route::resource('Administrador', 'AdministradorController');

Route::controller('Encargado','EncargadoController');

Route::get('Alumno','AlumnoController@getIndex');

Route::get('Alumno/Horario','HorarioController@getHorario');

Route::get('Alumno/consultaAlumno','ConsultaController@getconsultaAlumno');


Route::get('Docente','DocenteController@getIndex');

Route::get('Docente/HorarioDocente','HorarioController@getHorarioDocente');

Route::get('Docente/consultaDocente','ConsultaController@getconsultaDocente');



Route::controller('/','loginController');
Route::controller('/login','loginController');


Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
