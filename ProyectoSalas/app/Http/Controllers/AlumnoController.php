<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Horario;
use App\Models\Asignatura_cursada;
use App\Models\Periodo;
use App\Models\Campus;
use App\Models\Rol_usuario;



class AlumnoController extends Controller {


	protected $layout='layouts.master';

	public function getIndex()
	{	
		
		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre');  

		return view('Alumno/indexAlumno',compact('var'));

	}



	public function get_horario()
	{


		$datos_horario  = Asignatura_cursada::join('horarios', 'asignaturas_cursadas.curso_id', '=','horarios.curso_id')
				->join('salas', 'horarios.sala_id', '=','salas.id')
				->join('periodos', 'horarios.periodo_id', '=','periodos.id')
				->join('cursos', 'horarios.curso_id', '=','cursos.id')
				->join('asignaturas','cursos.asignatura_id','=','asignaturas.id')
				->join('estudiantes','asignaturas_cursadas.estudiante_id','=','estudiantes.id')
				->where('estudiantes.rut','=',\Auth::user()->rut) 
				->select('salas.nombre as sala','periodos.bloque','periodos.inicio','periodos.fin','asignaturas.nombre')
				->paginate();
				
		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre');  

		return view('Alumno/horario',compact('datos_horario','var'));

	}





	public function get_consulta()
	{
		$campus = Campus::paginate()->lists('nombre','id');
		$periodo = Periodo::paginate()->lists('bloque','id');

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre');  

		return view('Alumno/consulta',compact('campus','periodo','var'));
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

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre');  

		return view('Alumno/resultado',compact('resultados','var'));
		
		
	}

	

	

}
