<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Horario;
use App\Models\Asignatura_cursada;
use App\Models\Periodo;
use App\Models\Campus;



class AlumnoController extends Controller {


	protected $layout='layouts.master';

	public function getIndex()
	{	
			
		return view('Alumno/indexAlumno');

	}



	public function get_horario()
	{


		$datos_horario  = Asignatura_cursada::join('horarios', 'asignaturas_cursadas.curso_id', '=','horarios.curso_id')
				->join('salas', 'horarios.sala_id', '=','salas.id')
				->join('periodos', 'horarios.periodo_id', '=','periodos.id')
				->join('cursos', 'horarios.curso_id', '=','cursos.id')
				->join('asignaturas','cursos.asignatura_id','=','asignaturas.id')
				->where('asignaturas_cursadas.estudiante_id', '=', '4') //debe cambiar el id del estudiante
				->select('salas.nombre as sala','periodos.bloque','periodos.inicio','periodos.fin','asignaturas.nombre')
				->paginate();
				


		return view('Alumno/horario',compact('datos_horario'));

	}





	public function get_consulta()
	{
		$campus = Campus::paginate()->lists('nombre','id');
		$periodo = Periodo::paginate()->lists('bloque','id');

		return view('Alumno/consulta',compact('campus','periodo'));
	}


	public function get_resultado(Request $request)
	{
		
		$resultados = Horario::join('salas', 'horarios.sala_id', '=','salas.id')
				->join('periodos', 'horarios.periodo_id', '=','periodos.id')
				->join('cursos', 'horarios.curso_id', '=','cursos.id')
				->join('asignaturas','cursos.asignatura_id','=','asignaturas.id')
				->where('horarios.periodo_id', '=', $request->get('periodo'))
				->select('salas.nombre as sala','periodos.bloque','periodos.inicio','periodos.fin','asignaturas.nombre')
				->paginate();

		return view('Alumno/resultado',compact('resultados'));
		
		
	}

	

	

}
