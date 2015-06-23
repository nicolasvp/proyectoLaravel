<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use Request;
use Illuminate\Support\Facades\Session;

use App\Administrador;
use App\Roles_usuarios;
use App\Roles;
use App\Cursos;
use App\Asignaturas;
use App\Docentes;
use App\Carreras;
use App\Escuelas;
use App\Departamentos;
use App\Estudiantes;
use App\Facultades;
use App\Periodos;
use App\Funcionarios;



class AdministradorController extends Controller {


	protected $layout='layouts.master';


	public function getIndex()
	{
		$campus = Administrador::paginate();

		return view('Administrador/indexAdministrador',compact('campus'));
	}

	
	public function get_create()
	{
		return view('Administrador/create');
	}

	
	public function post_store()
	{
	
		$campus = new Administrador();
		$campus->fill(\Request::all());
		$campus->save();

		Session::flash('message', 'El campus ' .$campus->nombre.' fue creado');

		return redirect()->action('AdministradorController@getIndex');
	}

	
	public function get_show(Request $request)
	{
			

		$datos_usuario = \DB::table('roles_usuarios')
				->join('roles', 'roles_usuarios.rol_id', '=','roles.id')
				->where('roles_usuarios.rut', '=', $request->get('rut'))
				->select('roles_usuarios.id','roles_usuarios.rut','roles.nombre')
				->get();

		$rut = $request->get('rut');

				$rol_usuario = \DB::table('roles')->lists('nombre', 'id');

		//$rol_usuario = ['' => ''] + Roles::lists('nombre', 'id');	//agrega un null al principio

				return view('Administrador.show',compact('datos_usuario','rol_usuario','rut'));
			
	}
		
	
	public function get_edit(Request $request)
	{
		
		$campusEditable = Administrador::findOrFail($request->get('id'));
		$id = $request->get('id');
		return view('Administrador/edit', compact('campusEditable','id'));
	
	}

	public function put_update(Request $request)
	{
	
		$campusEditable = Administrador::findOrFail($request->get('id'));
		$campusEditable->fill(\Request::all());
		$campusEditable->save();
		
		return redirect()->action('AdministradorController@getIndex');
	}


	public function delete_destroy(Request $request)
	{

		$campusEditable = Administrador::findOrFail($request->get('id'));

		$campusEditable->forceDelete();

		Session::flash('message','El campus '. $campusEditable->nombre. ' fue eliminado');

		return redirect()->action('AdministradorController@getIndex');
		
	}


	public function get_search()
	{
			
		return view('Administrador.search');
	}


	public function post_profile(Request $request)
	{
	

		\DB::table('roles_usuarios')->insert(
    	['rut' => $request->get('rut'), 'rol_id' => $request->get('rol_asig')]
   		);
		Session::flash('message', 'El Perfil fue asignado exitosamente!, por favor vuelva al menú');

		return redirect()->action('AdministradorController@get_show');
	}

	public function delete_rol(Request $request)
	{

		
		$profile = Roles_usuarios::findOrFail($request->get('id'));

		$profile->delete();

		Session::flash('message', 'El Perfil fue removido exitosamente');

		return redirect()->action('AdministradorController@get_show');

	}

    //ARCHIVAR CAMPUS
	public function get_campus()
	{

		$campus = Administrador::paginate();


		return view('Administrador/campus_file',compact('campus'));

	}



	public function delete_campus(Request $request)
	{
		$file_campus = Administrador::findOrFail($request->get('id'));

		$file_campus->delete();	

		Session::flash('message', 'El campus fue archivado exitosamente!');

		return redirect()->action('AdministradorController@getIndex');

	}


	public function get_filed()
	{

		$filed_campus = Administrador::onlyTrashed()->paginate();

		return view('Administrador/campus_filed',compact('filed_campus'));
	}


	public function post_restore_campus(Request $request)
	{
		$restore_campus = Administrador::onlyTrashed()->where('id', $request->get('id'))->restore();
	
		Session::flash('message', 'El campus fue recuperado exitosamente!');

		return redirect()->action('AdministradorController@getIndex');
	}

	/*----------------------------------S A L A S ---------------------------------------------*/

	/* --------------------------------- C U R S O S -------------------------------------------*/
	public function get_carreras()
	{

		$carrera = Carreras::paginate()->lists('nombre','id');
		return view('Administrador/select_carrera_cursos',compact('carrera'));
	}


	public function get_cursos(Request $request)
	{
		/* FILTRAR LOS CURSOS POR CARRERAS
		$carrera = Carreras::findOrFail($request->get('carrera'));

		$escuela = Escuelas::findOrFail($carrera->escuela_id);

		$departamento = Departamentos::findOrFail($escuela->departamento_id);
*/ 
		$datos_cursos = \DB::table('cursos')
				->join('asignaturas', 'cursos.asignatura_id', '=','asignaturas.id')
				->join('docentes','cursos.docente_id','=','docentes.id')
				->select('cursos.*','asignaturas.nombre','docentes.nombres','docentes.apellidos','docentes.rut')
				->paginate();

		return view('Administrador/cursos_list',compact('datos_cursos'));
	}


	public function get_departamento()
	{
		$departamentos = Departamentos::paginate()->lists('nombre','id');
		return view('Administrador/select_departamento',compact('departamentos'));
	}


	public function get_createCurso(Request $request)
	{

		    $asignaturas = Asignaturas::where('departamento_id', '=', $request->get('departamentos'))->lists('nombre','id');
			
			$docentes = Docentes::where('departamento_id', '=', $request->get('departamentos'))->lists('apellidos','id');

			return view('Administrador/create_curso',compact('asignaturas','docentes'));
	}
	

	public function post_storeCurso()
	{
	
		$curso = new Cursos();
		$curso->fill(\Request::all());
		$curso->save();

		Session::flash('message', 'El curso fue creado exitosamente!');

		return redirect()->action('AdministradorController@get_cursos');
	}



		public function get_editCurso(Request $request)
	{
		
		$cursoEditable = Cursos::findOrFail($request->get('id'));

		$id = $request->get('id');

		$asignaturas = Asignaturas::paginate()->lists('nombre','id');

		$docentes = Docentes::paginate()->lists('apellidos','id');

		return view('Administrador/edit_curso', compact('cursoEditable','id','asignaturas','docentes'));
	
	}



	public function put_updateCurso(Request $request)
	{
	
		$curso = Cursos::findOrFail($request->get('id'));
		$curso->fill(\Request::all());
		$curso->save();
		
		return redirect()->action('AdministradorController@get_cursos');
	}

	public function delete_destroyCurso(Request $request)
	{

		$curso = Cursos::findOrFail($request->get('id'));

		//$curso_nombre = Asignaturas::where('id','=',$curso->asignatura_id)->select('nombre')->get();

		$curso->delete();


		Session::flash('message','El curso fue eliminado');

		return redirect()->action('AdministradorController@get_cursos');
		
	}

	/*---------------------------------------A S I G N A T U R A S---------------------------------------_*/

	public function get_carrera()
	{
		$carrera = Carreras::paginate()->lists('nombre','id');
		return view('Administrador/select_carrera',compact('carrera'));
	}



	public function get_asignaturas(Request $request)
	{
		$carrera = Carreras::findOrFail($request->get('carrera'));

		$escuela = Escuelas::findOrFail($carrera->escuela_id);

		$departamento = Departamentos::findOrFail($escuela->departamento_id);

		$datos_asignaturas = Asignaturas::where('departamento_id','=', $escuela->departamento_id)->paginate();
		


		return view('Administrador/asignaturas_list',compact('datos_asignaturas','departamento'));
	}


	public function get_createAsignatura()
	{

		$departamentos = Departamentos::paginate()->lists('nombre','id');

		return view('Administrador/create_asignatura',compact('departamentos'));
	}


	public function post_storeAsignatura()
	{
		
		$asignatura = new Asignaturas();
		$asignatura->fill(\Request::all());
		$asignatura->save();

		Session::flash('message', 'La asignatura fue creada exitosamente!');
		return redirect()->action('AdministradorController@getIndex');
	
	}



		public function get_editAsignatura(Request $request)
	{
		
		$asignaturaEditable = Asignaturas::findOrFail($request->get('id'));

		$id = $request->get('id');

		$departamentos = Departamentos::paginate()->lists('nombre','id');

		return view('Administrador/edit_asignatura', compact('asignaturaEditable','id','departamentos'));
	
	}



	public function put_updateAsignatura(Request $request)
	{
	
		$asignatura = Asignaturas::findOrFail($request->get('id'));
		$asignatura->fill(\Request::all());
		$asignatura->save();
		
		return redirect()->action('AdministradorController@get_carrera');
	}


	public function delete_destroyAsignatura(Request $request)
	{

		$asignatura = Asignaturas::findOrFail($request->get('id'));

		$asignatura->delete();


		Session::flash('message','La asignatura fue eliminada');

		return redirect()->action('AdministradorController@get_carrera');
		
	}

	/*------------------------ E S T U D I A N T E S ---------------------------------*/

	public function get_carrerass()
	{
		$carrera = Carreras::paginate()->lists('nombre','id');
		return view('Administrador/select_carrera_estudiante',compact('carrera'));
	}

	public function get_estudiantes(Request $request)
	{
		
		$datos_estudiantes = Estudiantes::where('carrera_id','=',$request->get('carrera'))->paginate();

		$carrera = Carreras::findOrFail($request->get('carrera'));

		return view('Administrador/estudiantes_list',compact('datos_estudiantes','carrera'));
	}



		public function get_createEstudiante()
	{

		$carreras = Carreras::paginate()->lists('nombre','id');

		return view('Administrador/create_estudiante',compact('carreras'));
	}


	public function post_storeEstudiante()
	{
		
		$estudiante = new Estudiantes();
		$estudiante->fill(\Request::all());
		$estudiante->save();

		Session::flash('message', 'El estudiante '.$estudiante->nombres.' '.$estudiante->apellidos.' fue creado exitosamente!');
		return redirect()->action('AdministradorController@get_carrerass');
	
	}





		public function get_editEstudiante(Request $request)
	{
		
		$estudianteEditable = Estudiantes::findOrFail($request->get('id'));

		$carreras = Carreras::paginate()->lists('nombre','id');

		$id = $request->get('id');

		return view('Administrador/edit_estudiante', compact('estudianteEditable','id','carreras'));
	
	}



	public function put_updateEstudiante(Request $request)
	{

		$estudiante = Estudiantes::findOrFail($request->get('id'));
		$estudiante->fill(\Request::all());
		$estudiante->save();
		
		Session::flash('message', 'El estudiante '.$estudiante->nombres.' '.$estudiante->apellidos.' fue editado exitosamente!');

		return redirect()->action('AdministradorController@get_carrerass');
	}


	public function delete_destroyEstudiante(Request $request)
	{

		$estudiante = Estudiantes::findOrFail($request->get('id'));

		$estudiante->delete();


		Session::flash('message', 'El estudiante '.$estudiante->nombres.' '.$estudiante->apellidos.' fue eliminado exitosamente!');

		return redirect()->action('AdministradorController@get_carrerass');
		
	}



	/*---------------------------------D O C E N T E S---------------------------------------------*/

	public function get_docentes()
	{
			
		$datos_docentes = Docentes::paginate();

		return view('Administrador/docentes_list',compact('datos_docentes'));
	}


	public function get_createDocente()
	{

		$departamentos = Departamentos::paginate()->lists('nombre','id');

		return view('Administrador/create_docente',compact('departamentos'));
	}


	public function post_storeDocente()
	{
		
		$docente= new Docentes();
		$docente->fill(\Request::all());
		$docente->save();

		Session::flash('message', 'El docente '.$docente->nombres.' '.$docente->apellidos.' fue creado exitosamente!');
		return redirect()->action('AdministradorController@get_docentes');
	
	}




	public function get_editDocente(Request $request)
	{
		
		$docenteEditable = Docentes::findOrFail($request->get('id'));

		$departamentos = Departamentos::paginate()->lists('nombre','id');

		$id = $request->get('id');

		return view('Administrador/edit_docente', compact('docenteEditable','id','departamentos'));
	
	}



	public function put_updateDocente(Request $request)
	{

		$estudiante = Docentes::findOrFail($request->get('id'));
		$estudiante->fill(\Request::all());
		$estudiante->save();
		
		Session::flash('message', 'El estudiante '.$estudiante->nombres.' '.$estudiante->apellidos.' fue editado exitosamente!');

		return redirect()->action('AdministradorController@get_docentes');
	}


	public function delete_destroyDocente(Request $request)
	{

		$docente = Docentes::findOrFail($request->get('id'));

		$docente->delete();


		Session::flash('message', 'El docente '.$docente->nombres.' '.$docente->apellidos.' fue eliminado exitosamente!');

		return redirect()->action('AdministradorController@get_docentes');
		
	}

/*-------------------------------C A R R E R A S--------------------------------------------*/


	public function get_list()
	{

		$datos_carreras = Carreras::paginate();

	
		return view('Administrador/carreras_list',compact('datos_carreras'));

	}


	public function get_createCarrera()
	{

		$escuelas = Escuelas::paginate()->lists('nombre','id');

		return view('Administrador/create_carrera',compact('escuelas'));
	}


	public function post_storeCarrera()
	{
		
		$carrera= new Carreras();
		$carrera->fill(\Request::all());
		$carrera->save();

		Session::flash('message', 'La carrera '.$carrera->nombre.' fue creada exitosamente!');
		return redirect()->action('AdministradorController@get_list');
	
	}



	public function get_editCarrera(Request $request)
	{
		
		$carreraEditable = Carreras::findOrFail($request->get('id'));

		$escuelas = Escuelas::paginate()->lists('nombre','id');

		$id = $request->get('id');

		return view('Administrador/edit_carrera', compact('carreraEditable','id','escuelas'));
	
	}



	public function put_updateCarrera(Request $request)
	{

		$carrera = Carreras::findOrFail($request->get('id'));
		$carrera->fill(\Request::all());
		$carrera->save();
		
		Session::flash('message', 'La carrera '.$carrera->nombre.' fue editada exitosamente!');

		return redirect()->action('AdministradorController@get_list');
	}


	public function delete_destroyCarrera(Request $request)
	{

		$carrera = Carreras::findOrFail($request->get('id'));

		$carrera->delete();


		Session::flash('message', 'La carrera '.$carrera->nombre.' fue eliminada exitosamente!');

		return redirect()->action('AdministradorController@get_list');
		
	}

/*--------------------------------------------D E P A R T A M E N T O S--------------------------------------*/


	public function get_departamentos()
	{

		$datos_departamentos = Departamentos::paginate();

	
		return view('Administrador/departamentos_list',compact('datos_departamentos'));

	}


	public function get_createDepartamento()
	{

		$facultades = Facultades::paginate()->lists('nombre','id');

		return view('Administrador/create_departamento',compact('facultades'));
	}


	public function post_storeDepartamento()
	{
		
		$departamento= new Departamentos();
		$departamento->fill(\Request::all());
		$departamento->save();

		Session::flash('message', 'El departamento '.$departamento->nombre.' fue creado exitosamente!');

		return redirect()->action('AdministradorController@get_departamentos');
	
	}



	public function get_editDepartamento(Request $request)
	{
		
		$departamentoEditable = Departamentos::findOrFail($request->get('id'));

		$facultades = Facultades::paginate()->lists('nombre','id');

		$id = $request->get('id');

		return view('Administrador/edit_departamento', compact('departamentoEditable','id','facultades'));
	
	}



	public function put_updateDepartamento(Request $request)
	{

		$departamento = Departamentos::findOrFail($request->get('id'));
		$departamento->fill(\Request::all());
		$departamento->save();
		
		Session::flash('message', 'El departamento '.$departamento->nombre.' fue editado exitosamente!');

		return redirect()->action('AdministradorController@get_departamentos');
	}


	public function delete_destroyDepartamento(Request $request)
	{

		$departamento = Departamentos::findOrFail($request->get('id'));

		$departamento->delete();


		Session::flash('message', 'El departamento '.$departamento->nombre.' fue eliminado exitosamente!');

		return redirect()->action('AdministradorController@get_departamentos');
		
	}

	/*-------------------------------E S C U E L A S---------------------------------------------*/

	public function get_escuelas()
	{

		$datos_escuelas = Escuelas::paginate();

	
		return view('Administrador/escuelas_list',compact('datos_escuelas'));

	}


	public function get_createEscuela()
	{

		$departamentos = Departamentos::paginate()->lists('nombre','id');

		return view('Administrador/create_escuela',compact('departamentos'));
	}


	public function post_storeEscuela()
	{
		
		$escuela= new Escuelas();
		$escuela->fill(\Request::all());
		$escuela->save();

		Session::flash('message', 'La escuela '.$escuela->nombre.' fue creada exitosamente!');

		return redirect()->action('AdministradorController@get_escuelas');
	
	}



	public function get_editEscuela(Request $request)
	{
		
		$escuelaEditable = Escuelas::findOrFail($request->get('id'));

		$departamentos = Departamentos::paginate()->lists('nombre','id');

		$id = $request->get('id');

		return view('Administrador/edit_escuela', compact('escuelaEditable','id','departamentos'));
	
	}



	public function put_updateEscuela(Request $request)
	{

		$escuela = Escuelas::findOrFail($request->get('id'));
		$escuela->fill(\Request::all());
		$escuela->save();
		
		Session::flash('message', 'La escuela '.$escuela->nombre.' fue editada exitosamente!');

		return redirect()->action('AdministradorController@get_escuelas');
	}


	public function delete_destroyEscuela(Request $request)
	{

		$escuela = Escuelas::findOrFail($request->get('id'));

		$escuela->delete();


		Session::flash('message', 'La escuela '.$escuela->nombre.' fue eliminada exitosamente!');

		return redirect()->action('AdministradorController@get_escuelas');
		
	}

	/*--------------------------F A C U L T A D E S-----------------------------------*/

	public function get_facultades()
	{

		$datos_facultades = Facultades::paginate();

	
		return view('Administrador/facultades_list',compact('datos_facultades'));

	}


	public function get_createFacultad()
	{

		$campus = Administrador::paginate()->lists('nombre','id');

		return view('Administrador/create_facultad',compact('campus'));
	}


	public function post_storeFacultad()
	{
		
		$facultad= new Facultades();
		$facultad->fill(\Request::all());
		$facultad->save();

		Session::flash('message', 'La facultad '.$facultad->nombre.' fue creada exitosamente!');

		return redirect()->action('AdministradorController@get_facultades');
	
	}



	public function get_editFacultad(Request $request)
	{
		
		$facultadEditable = Facultades::findOrFail($request->get('id'));

		$campus = Administrador::paginate()->lists('nombre','id');

		$id = $request->get('id');

		return view('Administrador/edit_facultad', compact('facultadEditable','id','campus'));
	
	}



	public function put_updateFacultad(Request $request)
	{

		$facultad = Facultades::findOrFail($request->get('id'));
		$facultad->fill(\Request::all());
		$facultad->save();
		
		Session::flash('message', 'La facultad '.$facultad->nombre.' fue editada exitosamente!');

		return redirect()->action('AdministradorController@get_facultades');
	}


	public function delete_destroyFacultad(Request $request)
	{

		$facultad = Facultades::findOrFail($request->get('id'));

		$facultad->delete();


		Session::flash('message', 'La facultad '.$facultad->nombre.' fue eliminada exitosamente!');

		return redirect()->action('AdministradorController@get_facultades');
		
	}

	/*--------------------------------------F U N C I O N A R I O S----------------------------------------*/


	public function get_funcionarios()
	{

		$datos_funcionarios = Funcionarios::paginate();

		return view('Administrador/funcionarios_list',compact('datos_funcionarios'));
	}

	public function get_createFuncionario()
	{

		$departamentos = Departamentos::paginate()->lists('nombre','id');
		return view('Administrador/create_funcionario',compact('departamentos'));
	}


	public function post_storeFuncionario()
	{
		
		$funcionario= new Funcionarios();
		$funcionario->fill(\Request::all());
		$funcionario->save();

		Session::flash('message', 'El funcionario '.$funcionario->nombres.' '.$funcionario->apellidos.' fue ingresado exitosamente!');

		return redirect()->action('AdministradorController@get_funcionarios');
	
	}



	public function get_editFuncionario(Request $request)
	{
		
		$funcionarioEditable = Funcionarios::findOrFail($request->get('id'));

		$departamentos = Departamentos::paginate()->lists('nombre','id');

		$id = $request->get('id');

		return view('Administrador/edit_funcionario', compact('funcionarioEditable','id','departamentos'));
	
	}



	public function put_updateFuncionario(Request $request)
	{

		$funcionario = Funcionarios::findOrFail($request->get('id'));
		$funcionario->fill(\Request::all());
		$funcionario->save();
		
		Session::flash('message', 'El funcionario '.$funcionario->nombres.' '.$funcionario->apellidos.' fue editado exitosamente!');

		return redirect()->action('AdministradorController@get_funcionarios');
	}


	public function delete_destroyFuncionario(Request $request)
	{

		$funcionario = Funcionarios::findOrFail($request->get('id'));

		$funcionario->delete();


		Session::flash('message', 'El funcionario '.$funcionario->nombres.' '.$funcionario->apellidos.' fue eliminado exitosamente!');

		return redirect()->action('AdministradorController@get_funcionarios');
		
	}


	/*--------------------------------------P E R I O D O S------------------------------------------------*/
	public function get_periodos()
	{

		$datos_periodos = Periodos::paginate();
		return view('Administrador/periodos_list',compact('datos_periodos'));
	}

	public function get_createPeriodo()
	{

		return view('Administrador/create_periodo');
	}


	public function post_storePeriodo()
	{
		
		$periodo= new Periodos();
		$periodo->fill(\Request::all());
		$periodo->save();

		Session::flash('message', 'El periodo '.$periodo->bloque.' fue creado exitosamente!');

		return redirect()->action('AdministradorController@get_periodos');
	
	}



	public function get_editPeriodo(Request $request)
	{
		
		$periodoEditable = Periodos::findOrFail($request->get('id'));


		$id = $request->get('id');

		return view('Administrador/edit_periodo', compact('periodoEditable','id'));
	
	}



	public function put_updatePeriodo(Request $request)
	{

		$periodo = Periodos::findOrFail($request->get('id'));
		$periodo->fill(\Request::all());
		$periodo->save();
		
		Session::flash('message', 'El periodo '.$periodo->bloque.' fue editado exitosamente!');

		return redirect()->action('AdministradorController@get_periodos');
	}


	public function delete_destroyPeriodo(Request $request)
	{

		$periodo = Periodos::findOrFail($request->get('id'));

		$periodo->delete();


		Session::flash('message', 'El periodo '.$periodo->bloque.' fue eliminado exitosamente!');

		return redirect()->action('AdministradorController@get_periodos');
		
	}

	/*--------------------------------------R O L E S-------------------------------------------------------*/
	public function get_roles()
	{

		$datos_roles = Roles::paginate();
		return view('Administrador/roles_list',compact('datos_roles'));
	}

	public function get_createRol()
	{

		return view('Administrador/create_rol');
	}


	public function post_storeRol()
	{
		
		$rol= new Roles();
		$rol->fill(\Request::all());
		$rol->save();

		Session::flash('message', 'El rol '.$rol->nombre.' fue creado exitosamente!');

		return redirect()->action('AdministradorController@get_roles');
	
	}



	public function get_editRol(Request $request)
	{
		
		$rolEditable = Roles::findOrFail($request->get('id'));


		$id = $request->get('id');

		return view('Administrador/edit_rol', compact('rolEditable','id'));
	
	}



	public function put_updateRol(Request $request)
	{

		$rol = Roles::findOrFail($request->get('id'));
		$rol->fill(\Request::all());
		$rol->save();
		
		Session::flash('message', 'El rol '.$rol->nombre.' fue editado exitosamente!');

		return redirect()->action('AdministradorController@get_roles');
	}


	public function delete_destroyRol(Request $request)
	{

		$rol = Roles::findOrFail($request->get('id'));

		$rol->delete();


		Session::flash('message', 'El rol '.$rol->nombre.' fue eliminado exitosamente!');

		return redirect()->action('AdministradorController@get_roles');
		
	}





}
