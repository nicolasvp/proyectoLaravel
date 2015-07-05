<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estudiantes;
use App\Models\Horarios;
use App\Models\Asignaturas_cursadas;
use App\Models\Periodos;
use App\Models\Campus;
use App\Models\Dias;
use App\Models\Asignaturas;
use App\Models\Cursos;

use App\Models\Carreras;

class AlumnoController extends Controller {


	protected $layout='layouts.master';

	public function getIndex()
	{	

	
		return view('Alumno/indexAlumno');

	}


	public function get_horario()
	{


		$datos_horario  = Asignaturas_cursadas::join('horarios', 'asignaturas_cursadas.curso_id', '=','horarios.curso_id')
				->join('salas', 'horarios.sala_id', '=','salas.id')
				->join('periodos', 'horarios.periodo_id', '=','periodos.id')
				->join('cursos', 'horarios.curso_id', '=','cursos.id')
				->join('asignaturas','cursos.asignatura_id','=','asignaturas.id')
				->join('dias','horarios.dia_id','=','dias.id')
				->where('asignaturas_cursadas.estudiante_id', '=', '4') //debe cambiar el id del estudiante
				->select('dias.nombre as dia','salas.nombre as sala','periodos.bloque','periodos.inicio','periodos.fin','asignaturas.nombre')
				->paginate();
				


		return view('Alumno/horario',compact('datos_horario'));

	}





	public function get_consulta()
	{
		$campus = Campus::paginate()->lists('nombre','id');
		$periodo = Periodos::paginate()->lists('bloque','id');
		$dia = Dias::paginate()->lists('nombre','id');

		return view('Alumno/consulta',compact('campus','periodo','dia'));
	}


	public function get_resultado(Request $request)
	{
		
		//$resultado = Horarios::where('periodo_id','=',$request->get('periodo'))->where('dia_id','=',$request->get('dia'))->get();

		$resultados = Horarios::join('salas', 'horarios.sala_id', '=','salas.id')
				->join('periodos', 'horarios.periodo_id', '=','periodos.id')
				->join('cursos', 'horarios.curso_id', '=','cursos.id')
				->join('asignaturas','cursos.asignatura_id','=','asignaturas.id')
				->join('dias','horarios.dia_id','=','dias.id')
				->where('horarios.periodo_id', '=', $request->get('periodo'))
				->where('horarios.dia_id','=', $request->get('dia')) 
				->select('dias.nombre as dia','salas.nombre as sala','periodos.bloque','periodos.inicio','periodos.fin','asignaturas.nombre')
				->paginate();

		return view('Alumno/resultado',compact('resultados'));
		
		
	}

	

	

}
