<?php namespace App\Http\Controllers\Administrador;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


use App\Models\Curso;
use App\Models\Periodo;
use App\Models\Sala;
use App\Models\Campus;
use App\Models\Horario;
use App\Models\Tipo_sala;
use App\Models\Rol_usuario;

use Carbon\Carbon;





class SalaController extends Controller {


	protected $layout='layouts.master';


	public function getIndex()
	{

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 
		
		return view('Administrador/salas/salas_index',compact('var'));
	}

	public function get_cursos()
	{
		$datos_cursos = Curso::join('asignaturas', 'cursos.asignatura_id', '=','asignaturas.id')
				->join('docentes','cursos.docente_id','=','docentes.id')
				->select('cursos.*','asignaturas.nombre','docentes.nombres','docentes.apellidos','docentes.rut')
				->paginate();

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/salas/curso_list',compact('datos_cursos','var'));
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

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/salas/curso_list',compact('datos_cursos','var'));
		}

		else
		{

		$datos_cursos = Curso::join('asignaturas', 'cursos.asignatura_id', '=','asignaturas.id')
				->join('docentes','cursos.docente_id','=','docentes.id')
				->select('cursos.*','asignaturas.nombre','docentes.nombres','docentes.apellidos','docentes.rut')
				->paginate();	

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/salas/curso_list',compact('datos_cursos','var'));

		}
	}




	public function get_campus(Request $request)
	{
		$campus = Campus::all()->lists('nombre','id');
		$id_curso = $request->get('id_curso');

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/salas/campus',compact('campus','id_curso','var'));
	}

	public function get_datos(Requests \SelectCampusRequest $request)
	{

		$datos_curso = Curso::join('asignaturas', 'cursos.asignatura_id', '=','asignaturas.id')
				->join('docentes','cursos.docente_id','=','docentes.id')
				->where('cursos.id', '=', $request->get('id_curso'))
				->select('cursos.*','asignaturas.nombre','docentes.nombres','docentes.apellidos','docentes.rut')
				->paginate();


		$periodos = Periodo::paginate()->lists('bloque','id');
		
		$salas = Sala::where('campus_id','=',$request->get('campus'))->get()->lists('nombre','id');

		$curso_id = $request->get('id_curso');


		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 		

		return view('Administrador/salas/create_horario',compact('datos_curso','periodos','salas','curso_id','var'));
	}



	public function post_storeCurso(Requests \CreateAsignarSalaRequest $request)
	{
	
			
		$inicio = new Carbon($request->inicio);
		$termino = new Carbon($request->termino);
	

		while($inicio <= $termino)
		{
			Carbon::setTestNow($inicio);
			if($request->lunes)
			{
				$lunes = new Carbon('this monday');
				if($lunes <= $termino)
				{
				$lun = new Horario();
				$lun->fill(['fecha' => $lunes,'sala_id' => $request->get('sala'),'periodo_id' => $request->get('periodo'),'curso_id' => $request->get('curso')]);
				$lun->save();
				}

			}
			if($request->martes)
			{
				$martes = new Carbon('this tuesday');
				if($martes <= $termino)
				{
				$mar = new Horario();
				$mar->fill(['fecha' => $martes,'sala_id' => $request->get('sala'),'periodo_id' => $request->get('periodo'),'curso_id' => $request->get('curso')]);
				$mar->save();
				}
			}
			if($request->miercoles)
			{
				$miercoles = new Carbon('this wednesday');
				if($miercoles <= $termino)
				{
				$mier = new Horario();
				$mier->fill(['fecha' => $miercoles,'sala_id' => $request->get('sala'),'periodo_id' => $request->get('periodo'),'curso_id' => $request->get('curso')]);
				$mier->save();
				}
			}
			if($request->jueves)
			{
				$jueves = new Carbon('this thursday');
				if($jueves <= $termino)
				{
				$jue = new Horario();
				$jue->fill(['fecha' => $jueves,'sala_id' => $request->get('sala'),'periodo_id' => $request->get('periodo'),'curso_id' => $request->get('curso')]);
				$jue->save();
				}
			}
			if($request->viernes)
			{
				$viernes = new Carbon('this friday');
				if($viernes <= $termino)
				{
				$vier = new Horario();
				$vier->fill(['fecha' => $viernes,'sala_id' => $request->get('sala'),'periodo_id' => $request->get('periodo'),'curso_id' => $request->get('curso')]);
				$vier->save();
				}
			}
			if($request->sabado)
			{
				$sabado = new Carbon('this saturday');
				if($sabado <= $termino)
				{
				$sab = new Horario();
				$sab->fill(['fecha' => $sabado,'sala_id' => $request->get('sala'),'periodo_id' => $request->get('periodo'),'curso_id' => $request->get('curso')]);
				$sab->save();
				}
			}

			$inicio->addWeek(1);
			
		}

		Session::flash('message', 'La sala fue asignada exitosamente!');

		
		return redirect()->action('Administrador\SalaController@get_horarios');
		



	}



	public function get_horarios()
	{

		$datos_horarios  = Horario::join('salas','horarios.sala_id','=','salas.id')
				->join('periodos', 'horarios.periodo_id', '=','periodos.id')
				->join('cursos', 'horarios.curso_id', '=','cursos.id')
				->join('asignaturas','cursos.asignatura_id','=','asignaturas.id')
				->join('campus','salas.campus_id','=','campus.id')
				->join('docentes','cursos.docente_id','=','docentes.id')
				->select('campus.nombre as campus','salas.nombre as sala','periodos.bloque','periodos.inicio','periodos.fin','asignaturas.nombre','horarios.id as horario_id','horarios.fecha','docentes.*')
				->paginate();
				
		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/salas/horarios_list',compact('datos_horarios','var'));


	}


	public function get_editHorario(Request $request)
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

		return view('Administrador/salas/edit_horario', compact('horarioEditable','periodos','salas','curso','curso_id','id','var'));

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
				->join('campus','salas.campus_id','=','campus.id')
				->join('docentes','cursos.docente_id','=','docentes.id')
				->where('asignaturas.nombre', 'like' , '%'.$request->get('name').'%')
				->orWhere('docentes.nombres','like', '%'.$request->get('name').'%')
				->orWhere('docentes.apellidos','like', '%'.$request->get('name').'%')
				->orWhere('campus.nombre','like','%'.$request->get('name').'%')
				->select('campus.nombre as campus','salas.nombre as sala','periodos.bloque','periodos.inicio','periodos.fin','asignaturas.nombre','horarios.id as horario_id','docentes.*')
				->paginate();

			$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

				return view('Administrador/salas/horarios_list',compact('datos_horarios','var'));
		}

		else
		{

			$datos_horarios  = Horario::join('salas','horarios.sala_id','=','salas.id')
				->join('periodos', 'horarios.periodo_id', '=','periodos.id')
				->join('cursos', 'horarios.curso_id', '=','cursos.id')
				->join('asignaturas','cursos.asignatura_id','=','asignaturas.id')
				->join('docentes','cursos.docente_id','=','docentes.id')
				->join('campus','salas.campus_id','=','campus.id')
				->select('campus.nombre as campus','salas.nombre as sala','periodos.bloque','periodos.inicio','periodos.fin','asignaturas.nombre','horarios.id as horario_id','docentes.*')
				->paginate();	

			$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/salas/horarios_list',compact('datos_horarios','var'));

		}
	}



	public function get_editSala(Request $request)
	{

		$datos_sala = Sala::findOrFail($request->get('sala'));
		
		$id = $request->get('sala');
		
		$campus = Campus::paginate()->lists('nombre','id');

		$tipos_salas = Tipo_sala::paginate()->lists('nombre','id');
				
		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/salas/edit_sala',compact('datos_sala','id','campus','tipos_salas','var'));
	}


	public function put_updateSala(Requests \EditSalaAdminRequest $request)
	{

		$sala = Sala::findOrFail($request->get('id'));
		$sala->fill(['campus_id' => $request->get('campus'),'tipo_sala_id' => $request->get('tipo_sala'),'nombre' => $request->get('nombre'),
			'descripcion' => $request->get('descripcion'),'capacidad' => $request->get('capacidad')]);
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

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/salas/salas_list',compact('datos_salas','var'));

	}


		public function get_createSala()
	{

		$campus = Campus::paginate()->lists('nombre','id');
		$tipos_salas = Tipo_sala::paginate()->lists('nombre','id');

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/salas/create_sala',compact('campus','tipos_salas','var'));
	}


	public function post_storeSala(Requests \CreateSalaRequest $request)
	{
	
		$sala= new Sala();
		$sala->fill(['campus_id' => $request->get('campus'),'tipo_sala_id' => $request->get('tipo_sala'),'nombre' => $request->get('nombre'),
			'descripcion' => $request->get('descripcion') ,'capacidad' => $request->get('capacidad')]);
		$sala->save();

		Session::flash('message', 'La sala '.$sala->nombre.' fue agregada exitosamente!');

		return redirect()->action('Administrador\SalaController@get_salasList');
	
	}


	public function delete_destroySala(Request $request)
	{

		$sala = Sala::findOrFail($request->get('sala'));

		$sala->delete();


		Session::flash('message', 'La sala '.$sala->nombre.' fue eliminada exitosamente!');

		return redirect()->action('Administrador\SalaController@get_salasList');
	}


	public function get_searchSala(Request $request)
	{
		if(trim($request->get('name')) != "")
		{

			$datos_salas  = Sala::join('campus','salas.campus_id','=','campus.id')
							->join('tipos_salas','salas.tipo_sala_id','=','tipos_salas.id')
							->where('campus.nombre','like','%'.$request->get('name').'%')
							->orWhere('tipos_salas.nombre','like','%'.$request->get('name').'%')
							->orWhere('salas.nombre','like','%'.$request->get('name').'%')
							->select('salas.*','campus.nombre as campus','tipos_salas.nombre as tipo_sala')
							->paginate();

			$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

				return view('Administrador/salas/salas_list',compact('datos_salas','var'));
		}

		else
		{

			$datos_salas = Sala::join('campus','salas.campus_id','=','campus.id')
							->join('tipos_salas','salas.tipo_sala_id','=','tipos_salas.id')
							->select('salas.*','tipos_salas.nombre as tipo_sala','campus.nombre as campus')
							->paginate();

			$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

				return view('Administrador/salas/salas_list',compact('datos_salas','var'));

		}
	}


}
