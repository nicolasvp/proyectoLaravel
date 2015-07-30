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


//Route::get('home', 'HomeController@index');

<<<<<<< HEAD
Route::group(['prefix' => 'encargado', 'namespace' => 'Encargado'], function()
=======
Route::group(['middleware' => ['auth','is_encargado'],'prefix' => 'encargado', 'namespace' => 'Encargado'], function()
>>>>>>> d54c8fa948ab220500fe59fd7e40157631c5a416
{

  	Route::get('/','EncargadoController@getIndex');
  	Route::controller('asignaturas','AsignaturaController');
  	Route::controller('salas','SalaController');
  	Route::controller('cursos','CursoController');
  	Route::controller('horarios','HorarioController');
  	Route::controller('docentes','DocenteController');
  	Route::controller('estudiantes','EstudianteController');



});

<<<<<<< HEAD
Route::group(['prefix' => 'administrador', 'namespace' => 'Administrador'], function()
=======
Route::group(['middleware' => ['auth','is_admin'], 'prefix' => 'administrador', 'namespace' => 'Administrador'], function()
>>>>>>> d54c8fa948ab220500fe59fd7e40157631c5a416
{
    Route::get('/','AdministradorController@getIndex');
    Route::controller('campus','CampusController');
    Route::controller('perfiles','PerfilController');
    Route::controller('salas','SalaController');
    Route::controller('tipos_salas','TipoSalaController');
    Route::controller('cursos','CursoController');
    Route::controller('asignaturas','AsignaturaController'); 
    Route::controller('estudiantes','EstudianteController');
    Route::controller('docentes','DocenteController');
    Route::controller('carreras','CarreraController');
    Route::controller('departamentos','DepartamentoController');
    Route::controller('escuelas','EscuelaController');
    Route::controller('facultades','FacultadController');
    Route::controller('funcionarios','FuncionarioController');
    Route::controller('periodos','PeriodoController');
    Route::controller('roles','RolController');
    Route::controller('roles_usuarios','RolUsuarioController'); 
<<<<<<< HEAD
    Route::controller('usuarios','UsuarioController');
=======
>>>>>>> d54c8fa948ab220500fe59fd7e40157631c5a416

});


//Route::group(['prefix' => 'estudiante', 'namespace' => 'EstudianteController'])
/*
Route::group(['middleware' => ['auth']], function(){
			Route::controllers([
						'admin' => 'AdministradorController',
						'alumno' => 'AlumnoController',
					//	'encargado' => 'EncargadoController',
						'docente' => 'DocenteController',
						]);
});


*/


Route::Controller("alumno","AlumnoController");
Route::Controller("docente","DocenteController");


Route::Controller("/login","loginController");
Route::Controller("/","loginController");
Route::get('/logout', 'LoginController@getLogout');

