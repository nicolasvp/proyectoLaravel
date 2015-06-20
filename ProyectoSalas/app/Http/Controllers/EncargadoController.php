<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Cursos;
use App\Administrador;
use App\Salas;
use App\Asignaturas;
use App\Docentes;
use App\Departamentos;
use App\Carreras;
use App\Estudiantes;
use App\Escuelas;


class EncargadoController extends Controller {


	protected $layout='layouts.master';

	public function getIndex()
	{

		return view('Encargado/indexEncargado');

	}


	public function get_cursos()
	{
		$datos_cursos = \DB::table('cursos')
				->join('asignaturas', 'cursos.asignatura_id', '=','asignaturas.id')
				->join('docentes','cursos.docente_id','=','docentes.id')
				->select('cursos.*','asignaturas.nombre','docentes.nombres','docentes.apellidos','docentes.rut')
				->paginate();


		return view('Encargado/cursos_list',compact('datos_cursos'));
	}



	public function get_search(Request $request)
	{
	
		if(trim($request->get('name')) != "")
		{
		$datos_cursos = \DB::table('cursos')
				->join('asignaturas', 'cursos.asignatura_id', '=','asignaturas.id')
				->join('docentes','cursos.docente_id','=','docentes.id')
				->where('asignaturas.nombre', '=' , $request->get('name'))
				->select('cursos.*','asignaturas.nombre','docentes.nombres','docentes.apellidos','docentes.rut')
				->paginate();	

		return view('Encargado/cursos_list',compact('datos_cursos'));
		}

		else
		{

		$datos_cursos = \DB::table('cursos')
				->join('asignaturas', 'cursos.asignatura_id', '=','asignaturas.id')
				->join('docentes','cursos.docente_id','=','docentes.id')
				->select('cursos.*','asignaturas.nombre','docentes.nombres','docentes.apellidos','docentes.rut')
				->paginate();	

		return view('Encargado/cursos_list',compact('datos_cursos'));
		}
	}







	public function post_curso(Request $request)
	{

		$datos_curso = \DB::table('cursos')
				->join('asignaturas', 'cursos.asignatura_id', '=','asignaturas.id')
				->join('docentes','cursos.docente_id','=','docentes.id')
				->where('cursos.id', '=', $request->get('id_curso'))
				->select('cursos.*','asignaturas.nombre','docentes.nombres','docentes.apellidos','docentes.rut')
				->paginate();


		$periodos = \DB::table('periodos')->lists('bloque','id');
		
		$salas = \DB::table('salas')->lists('nombre','id');

		$curso_id = $request->get('id_curso');

		return view('Encargado/add',compact('datos_curso','periodos','salas','curso_id'));
	}

	public function post_add(Request $request)
	{


		\DB::table('horarios')->insert(
    	['sala_id' => $request->get('asig_sala'), 'periodo_id' => $request->get('asig_periodo'),
    	'curso_id' => $request->get('curso_id')]);
		Session::flash('message', 'La sala fue asignada exitosamente!');

		return view('Encargado/indexEncargado');

	}





	public function get_campus()
	{


		$salas_campus = Administrador::paginate()->lists('nombre','id');
			
		return view('Encargado/select_campus',compact('salas_campus'));
	

	}


	public function get_salas(Request $request)
	{
		
		$salas = \DB::table('salas')
				->where('campus_id','=',$request->get('select_campus'))
				->lists('nombre','id');
	


		return view('Encargado/select_sala',compact('salas'));

	}

	public function get_edit(Request $request)
	{
		//dd($request->get('id_sala'));
		/*$datos_sala = \DB::table('salas')
					->where('id', '=' ,$request->get('id_sala'))
					->select('nombre','capacidad');
					*/
		$datos_sala = Salas::findOrFail($request->get('id_sala'));

		$id = $request->get('id_sala');

		return view('Encargado/edit_sala',compact('datos_sala','id'));
	}


	public function put_update(Request $request)
	{
	
		$sala = Salas::findOrFail($request->get('id'));
		$sala->fill(\Request::all());
		$sala->save();
		Session::flash('message', 'La sala fue modificada exitosamente!');
		return view('Encargado/indexEncargado');
	}



	public function get_ingreso()
	{
		$id_c= 1;
		$id_a= 2;
		$id_e= 3;
		return view('Encargado/ingreso_index',compact('id_c','id_a','id_e'));
	}



	public function get_departamento(Request $request)
	{
		$departamentos = Departamentos::paginate()->lists('nombre','id');
		$id = $request->get('id');
		return view('Encargado/select_departamento',compact('departamentos','id'));
	}


	public function get_escuela(Request $request)
	{

		$escuela = Escuelas::paginate()->lists('nombre','id');
		$id = $request->get('id');
		return view('Encargado/select_escuela',compact('escuela','id'));
	}



	public function get_create(Request $request)
	{
	
		if($request->get('id')==1)
		{
			$asignaturas = Asignaturas::where('departamento_id', '=', $request->get('departamentos'))->lists('nombre','id');
			
			$docentes = Docentes::where('departamento_id', '=', $request->get('departamentos'))->lists('apellidos','id');

			return view('Encargado/create_curso',compact('asignaturas','docentes'));
		}
		if($request->get('id')==2)
		{
			$departamentos = Departamentos::paginate()->lists('nombre','id');
			return view('Encargado/create_asignatura',compact('departamentos'));
		}	
		if($request->get('id')==3)
		{
			$carreras = Carreras::where('escuela_id', '=', $request->get('escuela'))->lists('nombre','id');
			return view('Encargado/create_estudiante',compact('carreras'));
		}

		
	}


	public function post_store()
	{
		//dd(\Request::get('docente_id'));
		$curso = new Cursos();
		$curso->fill(\Request::all());
		$curso->save();

		Session::flash('message', 'El curso fue creado exitosamente!');
		return redirect()->action('EncargadoController@getIndex');
	
	}

		public function post_storeAsignatura()
	{
		//dd(\Request::get('departamento_id'));
		$asignatura = new Asignaturas();
		$asignatura->fill(\Request::all());
		$asignatura->save();

		Session::flash('message', 'La asignatura fue creada exitosamente!');
		return redirect()->action('EncargadoController@getIndex');
	
	}


		public function post_storeEstudiante()
	{
		//dd(\Request::get('departamento_id'));
		$estudiante = new Estudiantes();
		$estudiante->fill(\Request::all());
		$estudiante->save();

		Session::flash('message', 'El estudiante fue creado exitosamente!');
		return redirect()->action('EncargadoController@getIndex');
	
	}




}
