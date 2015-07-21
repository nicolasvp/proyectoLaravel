<?php namespace App\Http\Controllers\Encargado;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


use App\Models\Sala;
use App\Models\Curso;
use App\Models\Periodo;
use App\Models\Horario;
use App\Models\Campus;
use App\Models\Dia;





class SalaController extends Controller {


	public function getIndex()
	{

		return view('Encargado/salas/ingreso_index');
	}


	public function get_curso()
	{

		$datos_cursos = Curso::join('asignaturas','cursos.asignatura_id','=','asignaturas.id')
		->join('docentes','cursos.docente_id','=','docentes.id')
		->select('cursos.*','docentes.nombres','docentes.apellidos','docentes.rut','asignaturas.nombre')
		->paginate();

		return view('Encargado/salas/cursos',compact('datos_cursos'));
	}





	public function get_datos(Request $request)
	{

		$datos_curso = Curso::join('asignaturas', 'cursos.asignatura_id', '=','asignaturas.id')
				->join('docentes','cursos.docente_id','=','docentes.id')
				->where('cursos.id', '=', $request->get('id_curso'))
				->select('cursos.*','asignaturas.nombre','docentes.nombres','docentes.apellidos','docentes.rut')
				->paginate();


		$periodos = Periodo::paginate()->lists('bloque','id');
		
		$salas = Sala::paginate()->lists('nombre','id');

		$curso_id = $request->get('id_curso');

		$dias = Dia::paginate()->lists('nombre','id');

		return view('Encargado/salas/create',compact('datos_curso','periodos','salas','curso_id','dias'));
	}




	public function post_store(Requests \AsignarSalaRequest $request)
	{
	
//dd($request);
		//$horario = new Horario();
		/*$horario = Horario::where('sala_id','=',$request->get('sala'),'and','periodo_id','=',$request->get('periodo'),
			'and','dia_id','=',$request->get('dia'))
		->select('horario.*')
		->paginate();*/
		$horario = \DB::table('horarios')->where('sala_id','=',$request->get('sala'),'and','periodo_id','=',$request->get('periodo'),
			'and','dia_id','=',$request->get('dia'))->get();
		
		if($horario!=null)
		dd($horario);
	else{
		dd('holra');
		$horario->fill(['sala_id' => $request->get('sala'), 'periodo_id' => $request->get('periodo'),
    	'curso_id' => $request->get('curso'),'dia_id' => $request->get('dia')]);
		$horario->save();
}

		Session::flash('message', 'La sala fue asignada exitosamente!');

		return redirect()->action('Encargado\HorarioController@getIndex');

	}






	public function get_searchCurso(Request $request)
	{
	
		if(trim($request->get('name')) != "")
		{

		$datos_cursos = Curso::join('asignaturas', 'cursos.asignatura_id', '=','asignaturas.id')
				->join('docentes','cursos.docente_id','=','docentes.id')
				->where('asignaturas.nombre', 'like' , '%'.$request->get('name').'%')
				->orWhere('docentes.rut','=',(integer) $request->get('name'))
				->orWhere('docentes.nombres','like', '%'.$request->get('name').'%')
				->orWhere('docentes.apellidos','like', '%'.$request->get('name').'%')
				->select('cursos.*','asignaturas.nombre','docentes.nombres','docentes.apellidos','docentes.rut')
				->paginate();	

		return view('Encargado/salas/cursos',compact('datos_cursos'));
		}

		else
		{

			return redirect()->action('Encargado\SalaController@get_curso');
		}
	}






	public function get_salas()
	{
		$datos_salas = Sala::join('campus','salas.campus_id','=','campus.id')
		->join('tipos_salas','salas.tipo_sala_id','=','tipos_salas.id')
		->select('salas.*','campus.nombre as campus','tipos_salas.nombre as tipo')
		->paginate();

	
		return view('Encargado/salas/salas',compact('datos_salas'));

	}

	public function get_edit(Request $request)
	{

		$datos_sala = Sala::findOrFail($request->get('id_sala'));

		$id = $request->get('id_sala');

		return view('Encargado/salas/edit',compact('datos_sala','id'));
	}


	public function put_update(Requests \EditSalaRequest $request)
	{
	
		$sala = Sala::findOrFail($request->get('id'));
		$sala->fill(\Request::all());
		$sala->save();
		Session::flash('message', 'La sala '.$sala->nombre.' fue modificada exitosamente!');

		return redirect()->action('Encargado\SalaController@get_salas');
	}



		public function get_search(Request $request)
	{
	
		if(trim($request->get('name')) != "")
		{

		$datos_salas = Sala::join('campus', 'salas.campus_id', '=','campus.id')
				->join('tipos_salas','salas.tipo_sala_id','=','tipos_salas.id')
				->where('campus.nombre', 'like' , '%'.$request->get('name').'%')
				->orWhere('salas.nombre','like', '%'.$request->get('name').'%')
				->orWhere('tipos_salas.nombre','like', '%'.$request->get('name').'%')
				->select('salas.*','campus.nombre as campus','tipos_salas.nombre as tipo')
				->paginate();	

		return view('Encargado/salas/salas',compact('datos_salas'));
		}

		else
		{

			return redirect()->action('Encargado\SalaController@get_salas');
		}
	}











	






}
