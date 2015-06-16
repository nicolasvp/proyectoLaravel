<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Cursos;



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


}
