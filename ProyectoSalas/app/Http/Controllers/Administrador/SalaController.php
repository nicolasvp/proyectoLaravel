<?php namespace App\Http\Controllers\Administrador;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use Request;
use Illuminate\Support\Facades\Session;


use App\Models\Curso;
use App\Models\Dia;
use App\Models\Periodo;
use App\Models\Sala;
use App\Models\Campus;
use App\Models\Horario;
use App\Models\Tipo_sala;





class SalaController extends Controller {


	protected $layout='layouts.master';


	public function getIndex()
	{
		
		return view('Administrador/salas/salas_index');
	}


	public function get_cursos()
	{
		$datos_cursos = Curso::join('asignaturas', 'cursos.asignatura_id', '=','asignaturas.id')
				->join('docentes','cursos.docente_id','=','docentes.id')
				->select('cursos.*','asignaturas.nombre','docentes.nombres','docentes.apellidos','docentes.rut')
				->paginate();


		return view('Administrador/salas/curso_list',compact('datos_cursos'));
	}



	public function get_searchCurso(Request $request)
	{
	

		if(trim($request->get('name')) != "")
		{
		$datos_cursos = Curso::join('asignaturas', 'cursos.asignatura_id', '=','asignaturas.id')
				->join('docentes','cursos.docente_id','=','docentes.id')
				->where('asignaturas.nombre', 'like' , '%'.$request->get('name').'%')
				->orWhere('docentes.nombres','like', '%'.$request->get('name').'%')
				->orWhere('docentes.apellidos','like', '%'.$request->get('name').'%')
				->select('cursos.*','asignaturas.nombre','docentes.nombres','docentes.apellidos','docentes.rut')
				->paginate();	

		return view('Administrador/salas/curso_list',compact('datos_cursos'));
		}

		else
		{

		$datos_cursos = Curso::join('asignaturas', 'cursos.asignatura_id', '=','asignaturas.id')
				->join('docentes','cursos.docente_id','=','docentes.id')
				->select('cursos.*','asignaturas.nombre','docentes.nombres','docentes.apellidos','docentes.rut')
				->paginate();	

		return view('Administrador/salas/curso_list',compact('datos_cursos'));

		}
	}




	public function post_curso(Request $request)
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

		return view('Administrador/salas/store_curso',compact('datos_curso','periodos','salas','curso_id','dias'));
	}



	public function post_storeCurso(Request $request)
	{
	
		
		$horario = new Horario();
		$horario->fill(['sala_id' => $request->get('asig_sala'), 'periodo_id' => $request->get('asig_periodo'),
    	'curso_id' => $request->get('curso_id'), 'dia_id' => $request->get('dia_id')]);
    	$horario->save();


		Session::flash('message', 'La sala fue asignada exitosamente!');

		
		return redirect()->action('Administrador\SalaController@get_horarios');
		

	}



	public function get_horarios()
	{

		$datos_horarios  = Horario::join('salas','horarios.sala_id','=','salas.id')
				->join('periodos', 'horarios.periodo_id', '=','periodos.id')
				->join('cursos', 'horarios.curso_id', '=','cursos.id')
				->join('asignaturas','cursos.asignatura_id','=','asignaturas.id')
				->join('dias','horarios.dia_id','=','dias.id')
				->join('docentes','cursos.docente_id','=','docentes.id')
				->select('dias.nombre as dia','salas.nombre as sala','periodos.bloque','periodos.inicio','periodos.fin','asignaturas.nombre','horarios.id as horario_id','docentes.*')
				->paginate();
				

		return view('Administrador/salas/horarios_list',compact('datos_horarios'));


	}


	public function get_editHorario(Request $request)
	{

		$horarioEditable = Horario::findOrFail($request->get('id'));

		$periodos = Periodo::paginate()->lists('bloque','id');

		$dias = Dia::paginate()->lists('nombre','id');

		$salas = Sala::paginate()->lists('nombre','id');

		
		$curso = Curso::join('asignaturas','cursos.asignatura_id','=','asignaturas.id')
		->where('cursos.id','=',$horarioEditable->curso_id)
		->select('asignaturas.nombre')
		->paginate();


		$id = $request->get('id');

		$curso_id = $horarioEditable->curso_id;

		return view('Administrador/salas/edit_horario', compact('horarioEditable','periodos','dias','salas','curso','curso_id','id'));

	}


	public function put_updateHorario(Request $request)
	{

		$horario = Horario::findOrFail($request->get('id'));
		$horario->fill(\Request::all());
		$horario->save();
		
		Session::flash('message', 'El horario fue editado exitosamente!');

		return redirect()->action('Administrador\SalaController@get_horarios');
	}


	
	public function delete_destroyHorario(Request $request)
	{
		$horario = Horario::findOrFail($request->get('id'));

		$horario->delete();


		Session::flash('message', 'El horario fue eliminado exitosamente!');

		return redirect()->action('Administrador\SalaController@get_horarios');
	}


	public function get_searchHorario(Request $request)
	{
	

		if(trim($request->get('name')) != "")
		{

			$datos_horarios  = Horario::join('salas','horarios.sala_id','=','salas.id')
				->join('periodos', 'horarios.periodo_id', '=','periodos.id')
				->join('cursos', 'horarios.curso_id', '=','cursos.id')
				->join('asignaturas','cursos.asignatura_id','=','asignaturas.id')
				->join('dias','horarios.dia_id','=','dias.id')
				->join('docentes','cursos.docente_id','=','docentes.id')
				->where('asignaturas.nombre', 'like' , '%'.$request->get('name').'%')
				->orWhere('docentes.nombres','like', '%'.$request->get('name').'%')
				->orWhere('docentes.apellidos','like', '%'.$request->get('name').'%')
				->select('dias.nombre as dia','salas.nombre as sala','periodos.bloque','periodos.inicio','periodos.fin','asignaturas.nombre','horarios.id as horario_id','docentes.*')
				->paginate();

				return view('Administrador/salas/horarios_list',compact('datos_horarios'));
		}

		else
		{

			$datos_horarios  = Horario::join('salas','horarios.sala_id','=','salas.id')
				->join('periodos', 'horarios.periodo_id', '=','periodos.id')
				->join('cursos', 'horarios.curso_id', '=','cursos.id')
				->join('asignaturas','cursos.asignatura_id','=','asignaturas.id')
				->join('dias','horarios.dia_id','=','dias.id')
				->join('docentes','cursos.docente_id','=','docentes.id')
				->select('dias.nombre as dia','salas.nombre as sala','periodos.bloque','periodos.inicio','periodos.fin','asignaturas.nombre','horarios.id as horario_id','docentes.*')
				->paginate();	

		return view('Administrador/salas/horarios_list',compact('datos_horarios'));

		}
	}



	public function get_selectCampus()
	{


		$salas_campus = Campus::paginate()->lists('nombre','id');
			
		return view('Administrador/salas/select_campus',compact('salas_campus'));
	

	}


	public function get_salas(Request $request)
	{
		$salas = Sala::where('campus_id','=',$request->get('select_campus'))->lists('nombre','id');

	
		return view('Administrador/salas/select_sala',compact('salas'));

	}

	public function get_editSala(Request $request)
	{

		$datos_sala = Sala::findOrFail($request->get('id_sala'));
		
		$id = $request->get('id_sala');
		
		$campus = Campus::paginate()->lists('nombre','id');

		$tipos_salas = Tipo_sala::paginate()->lists('nombre','id');
				
	
		return view('Administrador/salas/edit_sala',compact('datos_sala','id','campus','tipos_salas'));
	}


	public function put_updateSala(Request $request)
	{
	
		$sala = Sala::findOrFail($request->get('id'));
		$sala->fill(\Request::all());
		$sala->save();


		Session::flash('message', 'La sala '.$sala->nombre.' fue modificada exitosamente!');


		return redirect()->action('Administrador\SalaController@get_salasList');
	}


	public function get_salasList()
	{
		$datos_salas = Sala::join('campus','salas.campus_id','=','campus.id')
							->join('tipos_salas','salas.tipo_sala_id','=','tipos_salas.id')
							->select('salas.*','tipos_salas.nombre as tipo_sala','campus.nombre as campus')
							->paginate();

		return view('Administrador/salas/salas_list',compact('datos_salas'));

	}


		public function get_createSala()
	{

		$campus = Campus::paginate()->lists('nombre','id');
		$tipos_salas = Tipo_sala::paginate()->lists('nombre','id');
		return view('Administrador/salas/create_sala',compact('campus','tipos_salas'));
	}


	public function post_storeSala()
	{
	
		$sala= new Sala();
		$sala->fill(\Request::all());
		$sala->save();

		Session::flash('message', 'La sala '.$sala->nombre.' fue agregada exitosamente!');

		return redirect()->action('Administrador\SalaController@get_salasList');
	
	}


	public function delete_destroySala(Request $request)
	{

		$sala = Sala::findOrFail($request->get('id_sala'));

		$sala->delete();


		Session::flash('message', 'La sala '.$sala->nombre.' fue eliminada exitosamente!');

		return redirect()->action('Administrador\SalaController@get_salasList');
	}


}
