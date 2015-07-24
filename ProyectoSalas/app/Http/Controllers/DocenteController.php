<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estudiante;
use App\Models\Horario;
use App\Models\Asignaturas_cursada;
use App\Models\Periodo;
use App\Models\Campus;
use App\Models\Curso;
use App\Models\Rol_usuario;


class DocenteController extends Controller {


	protected $layout='layouts.master';

	public function getIndex()
	{

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre'); 

		return view('Docente/indexDocente',compact('var'));

	}

	public function get_horario()
	{

		
		$datos_horario  = Curso::join('horarios', 'cursos.id', '=','horarios.curso_id')
				->join('salas', 'horarios.sala_id', '=','salas.id')
				->join('periodos', 'horarios.periodo_id', '=','periodos.id')
				->join('asignaturas','cursos.asignatura_id','=','asignaturas.id')
				->where('cursos.docente_id', '=', '1') //debe cambiar el id del estudiante
				->select('salas.nombre as sala','periodos.bloque','periodos.inicio','periodos.fin','asignaturas.nombre')
				->paginate();
				
		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre'); 

		return view('Docente/horario',compact('datos_horario','var'));

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


	public function get_resultado(Request $request)
	{
		
		//$resultado = Horarios::where('periodo_id','=',$request->get('periodo'))->where('dia_id','=',$request->get('dia'))->get();

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

		return view('Docente/resultado',compact('resultados','var'));
		
		
	}


}
