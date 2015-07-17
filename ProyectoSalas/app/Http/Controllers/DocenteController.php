<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estudiante;
use App\Models\Horario;
use App\Models\Asignaturas_cursada;
use App\Models\Periodo;
use App\Models\Campu;
use App\Models\Dia;
use App\Models\Curso;


class DocenteController extends Controller {


	protected $layout='layouts.master';

	public function getIndex()
	{

		return view('Docente/indexDocente');

	}

	public function get_horario()
	{

		
		$datos_horario  = Curso::join('horarios', 'cursos.id', '=','horarios.curso_id')
				->join('salas', 'horarios.sala_id', '=','salas.id')
				->join('periodos', 'horarios.periodo_id', '=','periodos.id')
				->join('asignaturas','cursos.asignatura_id','=','asignaturas.id')
				->join('dias','horarios.dia_id','=','dias.id')
				->where('cursos.docente_id', '=', '1') //debe cambiar el id del estudiante
				->select('dias.nombre as dia','salas.nombre as sala','periodos.bloque','periodos.inicio','periodos.fin','asignaturas.nombre')
				->paginate();
				
		
		return view('Docente/horario',compact('datos_horario'));

	}



	public function get_consulta()
	{
		$campus = Campus::paginate()->lists('nombre','id');
		$periodo = Periodo::paginate()->lists('bloque','id');
		$dia = Dia::paginate()->lists('nombre','id');

		return view('Docente/consulta',compact('campus','periodo','dia'));
	}


	public function get_resultado(Request $request)
	{
		
		//$resultado = Horarios::where('periodo_id','=',$request->get('periodo'))->where('dia_id','=',$request->get('dia'))->get();

		$resultados = Horario::join('salas', 'horarios.sala_id', '=','salas.id')
				->join('periodos', 'horarios.periodo_id', '=','periodos.id')
				->join('cursos', 'horarios.curso_id', '=','cursos.id')
				->join('asignaturas','cursos.asignatura_id','=','asignaturas.id')
				->join('dias','horarios.dia_id','=','dias.id')
				->where('horarios.periodo_id', '=', $request->get('periodo'))
				->where('horarios.dia_id','=', $request->get('dia')) 
				->select('dias.nombre as dia','salas.nombre as sala','periodos.bloque','periodos.inicio','periodos.fin','asignaturas.nombre')
				->paginate();

		return view('Docente/resultado',compact('resultados'));
		
		
	}


}
