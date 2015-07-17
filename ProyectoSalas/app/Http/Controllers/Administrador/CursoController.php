<?php namespace App\Http\Controllers\Administrador;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use Request;
use Illuminate\Support\Facades\Session;


use App\Models\Curso;
use App\Models\Carrera;
use App\Models\Departamento;
use App\Models\Asignatura;
use App\Models\Docente;





class CursoController extends Controller {


	protected $layout='layouts.master';




	public function getIndex(Request $request)
	{
		/* FILTRAR LOS CURSOS POR CARRERAS
		$carrera = Carreras::findOrFail($request->get('carrera'));

		$escuela = Escuelas::findOrFail($carrera->escuela_id);

		$departamento = Departamentos::findOrFail($escuela->departamento_id);
*/ 
		$datos_cursos = Curso::join('asignaturas', 'cursos.asignatura_id', '=','asignaturas.id')
				->join('docentes','cursos.docente_id','=','docentes.id')
				->select('cursos.*','asignaturas.nombre','docentes.nombres','docentes.apellidos','docentes.rut')
				->paginate();

		return view('Administrador/cursos/list',compact('datos_cursos'));
	}


	public function get_departamento()
	{
		$departamentos = Departamento::paginate()->lists('nombre','id');
		return view('Administrador/cursos/select_departamento',compact('departamentos'));
	}


	public function get_create(Request $request)
	{

		    $asignaturas = Asignatura::where('departamento_id', '=', $request->get('departamentos'))->lists('nombre','id');
			
			$docentes = Docente::where('departamento_id', '=', $request->get('departamentos'))->lists('apellidos','id');

			return view('Administrador/cursos/create',compact('asignaturas','docentes'));
	}
	

	public function post_store()
	{
	
		$curso = new Curso();
		$curso->fill(\Request::all());
		$curso->save();

		Session::flash('message', 'El curso fue creado exitosamente!');

		return redirect()->action('Administrador\CursoController@getIndex');
	}



		public function get_edit(Request $request)
	{
		
		$cursoEditable = Curso::findOrFail($request->get('id'));

		$id = $request->get('id');

		$asignaturas = Asignatura::paginate()->lists('nombre','id');

		$docentes = Docente::paginate()->lists('apellidos','id');

		return view('Administrador/cursos/edit', compact('cursoEditable','id','asignaturas','docentes'));
	
	}



	public function put_update(Request $request)
	{
	
		$curso = Curso::findOrFail($request->get('id'));
		$curso->fill(\Request::all());
		$curso->save();
		
		return redirect()->action('Administrador\CursoController@getIndex');
	}

	public function delete_destroy(Request $request)
	{

		$curso = Curso::findOrFail($request->get('id'));

		$curso->delete();


		Session::flash('message','El curso fue eliminado');

		return redirect()->action('Administrador\CursoController@getIndex');
		
	}



}
