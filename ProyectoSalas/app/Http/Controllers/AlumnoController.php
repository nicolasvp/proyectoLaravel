<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estudiante;
use App\Models\Horario;
use App\Models\Asignatura_cursada;
use App\Models\Periodo;
use App\Models\Campus;
use App\Models\Dia;
use App\Models\Asignatura;
use App\Models\Curso;

use App\Models\Carrera;
use Carbon\Carbon;


class AlumnoController extends Controller {


	protected $layout='layouts.master';

	public function getIndex()
	{	
		$user = Horario::find(28);
		$fecha = new Carbon($user->created_at);



		//dd($fecha);

		//$horario = \DB::table('horarios')->insert()



		return view('Alumno/indexAlumno',compact('fecha'));

	}


	public function get_horario()
	{


		$datos_horario  = Asignatura_cursada::join('horarios', 'asignaturas_cursadas.curso_id', '=','horarios.curso_id')
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
		$periodo = Periodo::paginate()->lists('bloque','id');
		$dia = Dia::paginate()->lists('nombre','id');

		return view('Alumno/consulta',compact('campus','periodo','dia'));
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

		return view('Alumno/resultado',compact('resultados'));
		
		
	}

	

	

}
