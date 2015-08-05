<?php namespace App\Http\Controllers\Estudiante;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Horario;
use App\Models\Asignatura_cursada;
use App\Models\Periodo;
use App\Models\Campus;
use App\Models\Rol_usuario;
use App\Http\Requests;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class EstudianteController extends Controller {


	protected $layout='layouts.master';

	public function getIndex()
	{	
		
		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre');  

		return view('Estudiante/index',compact('var'));

	}



	public function get_horario()
	{


		$fechas  = Asignatura_cursada::join('horarios', 'asignaturas_cursadas.curso_id', '=','horarios.curso_id')
				->join('salas', 'horarios.sala_id', '=','salas.id')
				->join('periodos', 'horarios.periodo_id', '=','periodos.id')
				->join('cursos', 'horarios.curso_id', '=','cursos.id')
				->join('asignaturas','cursos.asignatura_id','=','asignaturas.id')
				->join('estudiantes','asignaturas_cursadas.estudiante_id','=','estudiantes.id')
				->where('estudiantes.rut','=',\Auth::user()->rut) 
				->select('horarios.fecha')
				->get();




		foreach($fechas as $fecha)
		{
			$i = strtotime($fecha->fecha);
			$dia = strftime("%A", $i); 


			if($dia == 'Monday')
			{
				$datos_lunes  = Asignatura_cursada::join('horarios', 'asignaturas_cursadas.curso_id', '=','horarios.curso_id')
								->join('salas', 'horarios.sala_id', '=','salas.id')
								->join('periodos', 'horarios.periodo_id', '=','periodos.id')
								->join('cursos', 'horarios.curso_id', '=','cursos.id')
								->join('asignaturas','cursos.asignatura_id','=','asignaturas.id')
								->join('estudiantes','asignaturas_cursadas.estudiante_id','=','estudiantes.id')
								->where('estudiantes.rut','=',\Auth::user()->rut)
								->where('horarios.fecha','=',$fecha->fecha)
								->select('salas.nombre as sala','horarios.fecha','periodos.bloque','periodos.inicio','periodos.fin','asignaturas.nombre')
								->get();
		
				break;
			}

			
		}

		foreach($fechas as $fecha)
		{
			$i = strtotime($fecha->fecha);
			$dia = strftime("%A", $i); 


			if($dia == 'Tuesday')
			{
				$datos_martes  = Asignatura_cursada::join('horarios', 'asignaturas_cursadas.curso_id', '=','horarios.curso_id')
									->join('salas', 'horarios.sala_id', '=','salas.id')
									->join('periodos', 'horarios.periodo_id', '=','periodos.id')
									->join('cursos', 'horarios.curso_id', '=','cursos.id')
									->join('asignaturas','cursos.asignatura_id','=','asignaturas.id')
									->join('estudiantes','asignaturas_cursadas.estudiante_id','=','estudiantes.id')
									->where('estudiantes.rut','=',\Auth::user()->rut)
									->where('horarios.fecha','=',$fecha->fecha)
									->select('salas.nombre as sala','horarios.fecha','periodos.bloque','periodos.inicio','periodos.fin','asignaturas.nombre')
									->get();
			
				break;
			}
							$datos_martes  = Asignatura_cursada::join('horarios', 'asignaturas_cursadas.curso_id', '=','horarios.curso_id')
									->join('salas', 'horarios.sala_id', '=','salas.id')
									->join('periodos', 'horarios.periodo_id', '=','periodos.id')
									->join('cursos', 'horarios.curso_id', '=','cursos.id')
									->join('asignaturas','cursos.asignatura_id','=','asignaturas.id')
									->join('estudiantes','asignaturas_cursadas.estudiante_id','=','estudiantes.id')
									->where('estudiantes.rut','=',\Auth::user()->rut)
									->where('horarios.fecha','=',null)
									->select('salas.nombre as sala','horarios.fecha','periodos.bloque','periodos.inicio','periodos.fin','asignaturas.nombre')
									->get();

			
		}

		foreach($fechas as $fecha)
		{
			$i = strtotime($fecha->fecha);
			$dia = strftime("%A", $i); 


			if($dia == 'Wednesday')
			{
				$datos_miercoles = Asignatura_cursada::join('horarios', 'asignaturas_cursadas.curso_id', '=','horarios.curso_id')
									->join('salas', 'horarios.sala_id', '=','salas.id')
									->join('periodos', 'horarios.periodo_id', '=','periodos.id')
									->join('cursos', 'horarios.curso_id', '=','cursos.id')
									->join('asignaturas','cursos.asignatura_id','=','asignaturas.id')
									->join('estudiantes','asignaturas_cursadas.estudiante_id','=','estudiantes.id')
									->where('estudiantes.rut','=',\Auth::user()->rut)
									->where('horarios.fecha','=',$fecha->fecha)
									->select('salas.nombre as sala','horarios.fecha','periodos.bloque','periodos.inicio','periodos.fin','asignaturas.nombre')
									->get();
			
				break;
			}
							$datos_miercoles  = Asignatura_cursada::join('horarios', 'asignaturas_cursadas.curso_id', '=','horarios.curso_id')
									->join('salas', 'horarios.sala_id', '=','salas.id')
									->join('periodos', 'horarios.periodo_id', '=','periodos.id')
									->join('cursos', 'horarios.curso_id', '=','cursos.id')
									->join('asignaturas','cursos.asignatura_id','=','asignaturas.id')
									->join('estudiantes','asignaturas_cursadas.estudiante_id','=','estudiantes.id')
									->where('estudiantes.rut','=',\Auth::user()->rut)
									->where('horarios.fecha','=',null)
									->select('salas.nombre as sala','horarios.fecha','periodos.bloque','periodos.inicio','periodos.fin','asignaturas.nombre')
									->get();

			
		}

		foreach($fechas as $fecha)
		{
			$i = strtotime($fecha->fecha);
			$dia = strftime("%A", $i); 


			if($dia == 'Thursday')
			{
				$datos_jueves  = Asignatura_cursada::join('horarios', 'asignaturas_cursadas.curso_id', '=','horarios.curso_id')
									->join('salas', 'horarios.sala_id', '=','salas.id')
									->join('periodos', 'horarios.periodo_id', '=','periodos.id')
									->join('cursos', 'horarios.curso_id', '=','cursos.id')
									->join('asignaturas','cursos.asignatura_id','=','asignaturas.id')
									->join('estudiantes','asignaturas_cursadas.estudiante_id','=','estudiantes.id')
									->where('estudiantes.rut','=',\Auth::user()->rut)
									->where('horarios.fecha','=',$fecha->fecha)
									->select('salas.nombre as sala','horarios.fecha','periodos.bloque','periodos.inicio','periodos.fin','asignaturas.nombre')
									->get();
			
				break;
			}
							$datos_jueves  = Asignatura_cursada::join('horarios', 'asignaturas_cursadas.curso_id', '=','horarios.curso_id')
									->join('salas', 'horarios.sala_id', '=','salas.id')
									->join('periodos', 'horarios.periodo_id', '=','periodos.id')
									->join('cursos', 'horarios.curso_id', '=','cursos.id')
									->join('asignaturas','cursos.asignatura_id','=','asignaturas.id')
									->join('estudiantes','asignaturas_cursadas.estudiante_id','=','estudiantes.id')
									->where('estudiantes.rut','=',\Auth::user()->rut)
									->where('horarios.fecha','=',null)
									->select('salas.nombre as sala','horarios.fecha','periodos.bloque','periodos.inicio','periodos.fin','asignaturas.nombre')
									->get();
			
		}		

		foreach($fechas as $fecha)
		{
			$i = strtotime($fecha->fecha);
			$dia = strftime("%A", $i); 


			if($dia == 'Friday')
			{
				$datos_viernes  = Asignatura_cursada::join('horarios', 'asignaturas_cursadas.curso_id', '=','horarios.curso_id')
									->join('salas', 'horarios.sala_id', '=','salas.id')
									->join('periodos', 'horarios.periodo_id', '=','periodos.id')
									->join('cursos', 'horarios.curso_id', '=','cursos.id')
									->join('asignaturas','cursos.asignatura_id','=','asignaturas.id')
									->join('estudiantes','asignaturas_cursadas.estudiante_id','=','estudiantes.id')
									->where('estudiantes.rut','=',\Auth::user()->rut)
									->where('horarios.fecha','=',$fecha->fecha)
									->select('salas.nombre as sala','horarios.fecha','periodos.bloque','periodos.inicio','periodos.fin','asignaturas.nombre')
									->get();
			
				break;
			}
							$datos_viernes  = Asignatura_cursada::join('horarios', 'asignaturas_cursadas.curso_id', '=','horarios.curso_id')
									->join('salas', 'horarios.sala_id', '=','salas.id')
									->join('periodos', 'horarios.periodo_id', '=','periodos.id')
									->join('cursos', 'horarios.curso_id', '=','cursos.id')
									->join('asignaturas','cursos.asignatura_id','=','asignaturas.id')
									->join('estudiantes','asignaturas_cursadas.estudiante_id','=','estudiantes.id')
									->where('estudiantes.rut','=',\Auth::user()->rut)
									->where('horarios.fecha','=',null)
									->select('salas.nombre as sala','horarios.fecha','periodos.bloque','periodos.inicio','periodos.fin','asignaturas.nombre')
									->get();
			
		}	

		foreach($fechas as $fecha)
		{
			$i = strtotime($fecha->fecha);
			$dia = strftime("%A", $i); 


			if($dia == 'Saturday')
			{
				$datos_sabado  = Asignatura_cursada::join('horarios', 'asignaturas_cursadas.curso_id', '=','horarios.curso_id')
									->join('salas', 'horarios.sala_id', '=','salas.id')
									->join('periodos', 'horarios.periodo_id', '=','periodos.id')
									->join('cursos', 'horarios.curso_id', '=','cursos.id')
									->join('asignaturas','cursos.asignatura_id','=','asignaturas.id')
									->join('estudiantes','asignaturas_cursadas.estudiante_id','=','estudiantes.id')
									->where('estudiantes.rut','=',\Auth::user()->rut)
									->where('horarios.fecha','=',$fecha->fecha)
									->select('salas.nombre as sala','horarios.fecha','periodos.bloque','periodos.inicio','periodos.fin','asignaturas.nombre')
									->get();
			
				break;
			}
							$datos_sabado = Asignatura_cursada::join('horarios', 'asignaturas_cursadas.curso_id', '=','horarios.curso_id')
									->join('salas', 'horarios.sala_id', '=','salas.id')
									->join('periodos', 'horarios.periodo_id', '=','periodos.id')
									->join('cursos', 'horarios.curso_id', '=','cursos.id')
									->join('asignaturas','cursos.asignatura_id','=','asignaturas.id')
									->join('estudiantes','asignaturas_cursadas.estudiante_id','=','estudiantes.id')
									->where('estudiantes.rut','=',\Auth::user()->rut)
									->where('horarios.fecha','=',null)
									->select('salas.nombre as sala','horarios.fecha','periodos.bloque','periodos.inicio','periodos.fin','asignaturas.nombre')
									->get();
			
		}

		
		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre');  

		return view('Estudiante/horario',compact('datos_lunes','datos_martes','datos_miercoles','datos_jueves','datos_viernes','datos_sabado','var'));

	}





	public function get_consulta()
	{
		$campus = Campus::paginate()->lists('nombre','id');
		$periodo = Periodo::paginate()->lists('bloque','id');

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre');  

		return view('Estudiante/consulta',compact('campus','periodo','var'));
	}


	public function get_resultado(Requests \ConsultaRequest $request)
	{

		$fecha = new Carbon($request->dia);

		$resultados = Horario::join('salas', 'horarios.sala_id', '=','salas.id')
					->join('periodos', 'horarios.periodo_id', '=','periodos.id')
					->join('cursos', 'horarios.curso_id', '=','cursos.id')
					->join('asignaturas','cursos.asignatura_id','=','asignaturas.id')
					->join('campus','salas.campus_id','=','campus.id')
					->where('horarios.fecha', '=', $fecha)
					->where('campus.id','=', $request->get('campus'))
					->where('periodos.id','=',$request->get('periodo'))
					->select('campus.nombre as campus','horarios.fecha','salas.nombre as sala','periodos.bloque','periodos.inicio','periodos.fin','asignaturas.nombre')
					->paginate();

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre');  


        if(!$resultados->isEmpty())
        {
			return view('Estudiante/resultado',compact('resultados','var'));
		}

		Session::flash('message', 'No se encontraron resultados.');
		return view('Estudiante/resultado',compact('resultados','var'));
		
	}

	

	

}
