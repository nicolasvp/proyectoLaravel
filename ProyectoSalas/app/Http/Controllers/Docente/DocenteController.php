<?php namespace App\Http\Controllers\Docente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Estudiante;
use App\Models\Horario;
use App\Models\Asignaturas_cursada;
use App\Models\Periodo;
use App\Models\Campus;
use App\Models\Curso;
use App\Models\Rol_usuario;
use App\Models\Asignatura_cursada;

class DocenteController extends Controller {


	protected $layout='layouts.master';

	public function getIndex()
	{

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre'); 

		return view('Docente/index',compact('var'));

	}

	public function get_horario()
	{


		$fechas  = Horario::join('cursos','horarios.curso_id','=','cursos.id')
							->join('asignaturas','cursos.asignatura_id','=','asignaturas.id')
							->join('docentes','cursos.docente_id','=','docentes.id')
							->where('docentes.rut','=',\Auth::user()->rut) 
							->select('horarios.fecha')
							->get();

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre'); 

		$datos_lunes  = Horario::join('cursos','horarios.curso_id','=','cursos.id')
										->join('asignaturas','cursos.asignatura_id','=','asignaturas.id')
										->join('docentes','cursos.docente_id','=','docentes.id')
										->join('salas', 'horarios.sala_id', '=','salas.id')
										->join('periodos', 'horarios.periodo_id', '=','periodos.id')
										->where('docentes.rut','=',\Auth::user()->rut) 
										->where('horarios.fecha','=',null)
										->select('salas.nombre as sala','horarios.fecha','periodos.bloque','periodos.inicio','periodos.fin','asignaturas.nombre')
										->get();

		$datos_martes = $datos_lunes;
		$datos_miercoles = $datos_lunes;
		$datos_jueves = $datos_lunes;
		$datos_viernes =$datos_lunes;
		$datos_sabado = $datos_lunes;

	if(!is_null($fechas))	
	{	
		foreach($fechas as $fecha)
		{
			$i = strtotime($fecha->fecha);
			$dia = strftime("%A", $i); 


			if($dia == 'Monday')
			{
				$datos_lunes  = Horario::join('cursos','horarios.curso_id','=','cursos.id')
										->join('asignaturas','cursos.asignatura_id','=','asignaturas.id')
										->join('docentes','cursos.docente_id','=','docentes.id')
										->join('salas', 'horarios.sala_id', '=','salas.id')
										->join('periodos', 'horarios.periodo_id', '=','periodos.id')
										->where('docentes.rut','=',\Auth::user()->rut) 
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
				$datos_martes  = Horario::join('cursos','horarios.curso_id','=','cursos.id')
										->join('asignaturas','cursos.asignatura_id','=','asignaturas.id')
										->join('docentes','cursos.docente_id','=','docentes.id')
										->join('salas', 'horarios.sala_id', '=','salas.id')
										->join('periodos', 'horarios.periodo_id', '=','periodos.id')
										->where('docentes.rut','=',\Auth::user()->rut) 
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


			if($dia == 'Wednesday')
			{
				$datos_miercoles = Horario::join('cursos','horarios.curso_id','=','cursos.id')
										->join('asignaturas','cursos.asignatura_id','=','asignaturas.id')
										->join('docentes','cursos.docente_id','=','docentes.id')
										->join('salas', 'horarios.sala_id', '=','salas.id')
										->join('periodos', 'horarios.periodo_id', '=','periodos.id')
										->where('docentes.rut','=',\Auth::user()->rut) 
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


			if($dia == 'Thursday')
			{
				$datos_jueves  = Horario::join('cursos','horarios.curso_id','=','cursos.id')
										->join('asignaturas','cursos.asignatura_id','=','asignaturas.id')
										->join('docentes','cursos.docente_id','=','docentes.id')
										->join('salas', 'horarios.sala_id', '=','salas.id')
										->join('periodos', 'horarios.periodo_id', '=','periodos.id')
										->where('docentes.rut','=',\Auth::user()->rut) 
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


			if($dia == 'Friday')
			{
				$datos_viernes  = Horario::join('cursos','horarios.curso_id','=','cursos.id')
										->join('asignaturas','cursos.asignatura_id','=','asignaturas.id')
										->join('docentes','cursos.docente_id','=','docentes.id')
										->join('salas', 'horarios.sala_id', '=','salas.id')
										->join('periodos', 'horarios.periodo_id', '=','periodos.id')
										->where('docentes.rut','=',\Auth::user()->rut) 
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


			if($dia == 'Saturday')
			{
				$datos_sabado  = Horario::join('cursos','horarios.curso_id','=','cursos.id')
										->join('asignaturas','cursos.asignatura_id','=','asignaturas.id')
										->join('docentes','cursos.docente_id','=','docentes.id')
										->join('salas', 'horarios.sala_id', '=','salas.id')
										->join('periodos', 'horarios.periodo_id', '=','periodos.id')
										->where('docentes.rut','=',\Auth::user()->rut) 
										->where('horarios.fecha','=',$fecha->fecha)
										->select('salas.nombre as sala','horarios.fecha','periodos.bloque','periodos.inicio','periodos.fin','asignaturas.nombre')
										->get();
			
				break;
			}

		}

		
 

		return view('Docente/horario',compact('datos_lunes','datos_martes','datos_miercoles','datos_jueves','datos_viernes','datos_sabado','var'));
	}


		Session::flash('message', 'No tiene cursos disponibles.');
		return redirect()->action('Docente/DocenteController@getIndex');


	}



	public function get_consulta()
	{
		$campus = Campus::paginate()->lists('nombre','id');
		$periodo = Periodo::paginate()->lists('bloque','id');

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre'); 

		return view('Docente/consulta',compact('campus','periodo','var'));
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
			return view('Docente/resultado',compact('resultados','var'));
		}

		Session::flash('message', 'No se encontraron resultados.');
		return view('Docente/resultado',compact('resultados','var'));
		
		
	}


}
