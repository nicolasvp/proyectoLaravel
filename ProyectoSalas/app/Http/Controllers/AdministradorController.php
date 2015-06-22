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
		return redirect()->action('AdministradorController@getIndex');
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

	
}
