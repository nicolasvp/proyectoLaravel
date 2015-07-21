<?php namespace App\Http\Controllers\Encargado;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


use App\Models\Departamento;
use App\Models\Docente;
use App\Models\Curso;
use App\Models\Asignatura;



class CursoController extends Controller {

	public function get_departamento()
	{
		$departamentos = Departamento::paginate()->lists('nombre','id');
		return view('Encargado/cursos/departamento',compact('departamentos'));
	}



	public function getIndex()
	{
		$datos_cursos = Curso::join('asignaturas', 'cursos.asignatura_id', '=','asignaturas.id')
				->join('docentes','cursos.docente_id','=','docentes.id')
				->select('cursos.*','asignaturas.nombre','docentes.nombres','docentes.apellidos','docentes.rut')
				->paginate();


		return view('Encargado/cursos/list',compact('datos_cursos'));
	}


	public function get_create(Requests \SelectDeptoRequest $request)
	{

		    $asignaturas = Asignatura::where('departamento_id', '=', $request->get('departamento'))->lists('nombre','id');
			
			$docentes = Docente::where('departamento_id', '=', $request->get('departamento'))->lists('apellidos','id');

			return view('Encargado/cursos/create',compact('asignaturas','docentes'));
	}
	

	public function post_store(Requests \CreateCursoRequest $request)
	{
	
		$curso = new Curso();
		$curso->fill(['asignatura_id' => $request->get('asignatura'), 'docente_id' => $request->get('docente'),
			'semestre' => $request->get('semestre'), 'anio' => $request->get('año'), 'seccion' => $request->get('seccion')]);
		$curso->save();

		Session::flash('message', 'El curso fue creado exitosamente!');

		return redirect()->action('Encargado\CursoController@getIndex');
	}



		public function get_edit(Request $request)
	{
		
		$cursoEditable = Curso::findOrFail($request->get('id'));

		$id = $request->get('id');

		$asignaturas = Asignatura::paginate()->lists('nombre','id');

		$docentes = Docente::paginate()->lists('apellidos','id');

		return view('Encargado/cursos/edit', compact('cursoEditable','id','asignaturas','docentes'));
	
	}



	public function put_update(Requests \EditCursoRequest $request)
	{
	
		$curso = Curso::findOrFail($request->get('id'));
		$curso->fill(\Request::all());
		$curso->save();

		Session::flash('message','El curso fue editado exitosamente');

		return redirect()->action('Encargado\CursoController@getIndex');
	}

	public function delete_destroy(Request $request)
	{

		$curso = Curso::findOrFail($request->get('id'));

		$curso->delete();


		Session::flash('message','El curso fue eliminado exitosamente');

		return redirect()->action('Encargado\CursoController@getIndex');
		
	}

	public function get_search(Request $request)
		{
		
			if(trim($request->get('name')) != "")
			{

			 $datos_cursos = Curso::join('docentes','cursos.docente_id','=','docentes.id')
			 ->join('asignaturas','cursos.asignatura_id','=','asignaturas.id')
			 ->where('docentes.rut','=', (integer) $request->get('name'))
			 ->orWhere('docentes.nombres', 'like' , '%'.$request->get('name').'%')
			 ->orWhere('docentes.apellidos', 'like' , '%'.$request->get('name').'%')
			 ->orWhere('asignaturas.nombre','like','%'.$request->get('name').'%')
			 ->select('cursos.*','asignaturas.nombre','docentes.nombres','docentes.apellidos','docentes.rut')
			 ->paginate();

			return view('Encargado/cursos/list',compact('datos_cursos'));
			}

			else
			{

		 	return redirect()->action('Encargado\CursoController@getIndex');

			}
		}
}
