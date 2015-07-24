<?php namespace App\Http\Controllers\Encargado;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


use App\Models\Asignatura;
use App\Models\Departamento;
use App\Models\Horario;
use App\Models\Periodo;
use App\Models\Sala;
use App\Models\Curso;
use App\Models\Rol_usuario;



class HorarioController extends Controller {




public function getIndex()
	{

		$datos_horarios  = Horario::join('salas','horarios.sala_id','=','salas.id')
				->join('periodos', 'horarios.periodo_id', '=','periodos.id')
				->join('cursos', 'horarios.curso_id', '=','cursos.id')
				->join('asignaturas','cursos.asignatura_id','=','asignaturas.id')
				->join('docentes','cursos.docente_id','=','docentes.id')
				->join('campus','salas.campus_id','=','campus.id')
				->select('campus.nombre as campus','horarios.fecha','salas.nombre as sala','periodos.bloque','periodos.inicio','periodos.fin','asignaturas.nombre','horarios.id as horario_id','docentes.*')
				->paginate();

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre'); 

		return view('Encargado/horarios/list',compact('datos_horarios','var'));
	}


	public function get_search(Request $request)
	{
	
		if(trim($request->get('name')) != "")
		{
			
		$datos_horarios  = Horario::join('salas','horarios.sala_id','=','salas.id')
				->join('periodos', 'horarios.periodo_id', '=','periodos.id')
				->join('cursos', 'horarios.curso_id', '=','cursos.id')
				->join('asignaturas','cursos.asignatura_id','=','asignaturas.id')
				->join('docentes','cursos.docente_id','=','docentes.id')
				->join('campus','salas.campus_id','=','campus.id')
				->where('asignaturas.nombre', 'like' , '%'.$request->get('name').'%')
				->select('campus.nombre as campus','salas.nombre as sala','periodos.bloque','periodos.inicio','periodos.fin','asignaturas.nombre','horarios.id as horario_id','docentes.*')
				->paginate();

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre'); 


		return view('Encargado/horarios/list',compact('datos_horarios','var'));

		}

		else
		{

			return redirect()->action('Encargado\HorarioController@getIndex');
		}

	}


	public function get_edit(Request $request)
	{

		$horarioEditable = Horario::findOrFail($request->get('id'));

		$periodos = Periodo::paginate()->lists('bloque','id');


		$salas = Sala::paginate()->lists('nombre','id');

		
		$curso = Curso::join('asignaturas','cursos.asignatura_id','=','asignaturas.id')
		->where('cursos.id','=',$horarioEditable->curso_id)
		->select('asignaturas.nombre')
		->paginate();


		$id = $request->get('id');

		$curso_id = $horarioEditable->curso_id;

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre'); 

		return view('Encargado/horarios/edit', compact('horarioEditable','periodos','salas','curso','curso_id','id','var'));

	}


	public function put_update(Request $request)
	{

		$horario = Horario::findOrFail($request->get('id'));
		$horario->fill(\Request::all());
		$horario->save();
		
		Session::flash('message', 'El horario fue editado exitosamente!');

		return redirect()->action('Encargado\HorarioController@getIndex');
	}



	public function delete_destroy(Request $request)
	{
		$horario = Horario::findOrFail($request->get('id'));

		$horario->delete();


		Session::flash('message', 'El horario fue eliminado exitosamente!');

		return redirect()->action('Encargado\HorarioController@getIndex');
	}



}
