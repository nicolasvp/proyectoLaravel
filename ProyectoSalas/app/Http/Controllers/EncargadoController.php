<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Cursos;
use App\Models\Campus;
use App\Models\Salas;
use App\Models\Asignaturas;
use App\Models\Docentes;
use App\Models\Departamentos;
use App\Models\Carreras;
use App\Models\Estudiantes;
use App\Models\Escuelas;
use App\Models\Horarios;
use App\Models\Dias;
use App\Models\Periodos;


class EncargadoController extends Controller {


	protected $layout='layouts.master';


	public function getIndex()
	{

		return view('Encargado/indexEncargado');

	}

/*--------------------------------------------------------S A L A S-------------------------------------------------*/

	public function get_selectCurso()
	{

		$datos_cursos = Cursos::join('asignaturas','cursos.asignatura_id','=','asignaturas.id')
		->join('docentes','cursos.docente_id','=','docentes.id')
		->select('cursos.*','docentes.nombres','docentes.apellidos','docentes.rut','asignaturas.nombre')
		->paginate();

		return view('Encargado/salas/cursos_select',compact('datos_cursos'));
	}


	public function get_search(Request $request)
	{
	
		if(trim($request->get('name')) != "")
		{

		$datos_cursos = Cursos::join('asignaturas', 'cursos.asignatura_id', '=','asignaturas.id')
				->join('docentes','cursos.docente_id','=','docentes.id')
				->where('asignaturas.nombre', 'like' , '%'.$request->get('name').'%')
				->orWhere('docentes.nombres','like', '%'.$request->get('name').'%')
				->orWhere('docentes.apellidos','like', '%'.$request->get('name').'%')
				->select('cursos.*','asignaturas.nombre','docentes.nombres','docentes.apellidos','docentes.rut')
				->paginate();	

		return view('Encargado/salas/cursos_select',compact('datos_cursos'));
		}

		else
		{

			return redirect()->action('EncargadoController@get_selectCurso');
		}
	}




	public function post_curso(Request $request)
	{

		$datos_curso = Cursos::join('asignaturas', 'cursos.asignatura_id', '=','asignaturas.id')
				->join('docentes','cursos.docente_id','=','docentes.id')
				->where('cursos.id', '=', $request->get('id_curso'))
				->select('cursos.*','asignaturas.nombre','docentes.nombres','docentes.apellidos','docentes.rut')
				->paginate();


		$periodos = Periodos::paginate()->lists('bloque','id');
		
		$salas = Salas::paginate()->lists('nombre','id');

		$curso_id = $request->get('id_curso');

		$dias = Dias::paginate()->lists('nombre','id');

		return view('Encargado/salas/add',compact('datos_curso','periodos','salas','curso_id','dias'));
	}




	public function post_add(Request $request)
	{
	

		$horario = new Horarios();
		$horario->fill(['sala_id' => $request->get('asig_sala'), 'periodo_id' => $request->get('asig_periodo'),
    	'curso_id' => $request->get('curso_id'),'dia_id' => $request->get('dia_id')]);
		$horario->save();


		Session::flash('message', 'La sala fue asignada exitosamente!');

		return redirect()->action('EncargadoController@get_horarios');

	}



	public function get_campus()
	{


		$salas_campus = Campus::paginate()->lists('nombre','id');
			
		return view('Encargado/select_campus',compact('salas_campus'));
	

	}


	public function get_salas()
	{
		$datos_salas = Salas::join('campus','salas.campus_id','=','campus.id')
		->join('tipos_salas','salas.tipo_sala_id','=','tipos_salas.id')
		->select('salas.*','campus.nombre as campus','tipos_salas.nombre as tipo')
		->paginate();

	
		return view('Encargado/salas/salas_list',compact('datos_salas'));

	}

	public function get_editSala(Request $request)
	{

		$datos_sala = Salas::findOrFail($request->get('id_sala'));

		$id = $request->get('id_sala');

		return view('Encargado/salas/edit_sala',compact('datos_sala','id'));
	}


	public function put_updateSala(Request $request)
	{
	
		$sala = Salas::findOrFail($request->get('id'));
		$sala->fill(\Request::all());
		$sala->save();
		Session::flash('message', 'La sala fue modificada exitosamente!');

		return redirect()->action('EncargadoController@get_salas');
	}

	public function get_searchSala(Request $request)
	{
	
		if(trim($request->get('name')) != "")
		{

		$datos_salas = Salas::join('campus', 'salas.campus_id', '=','campus.id')
				->join('tipos_salas','salas.tipo_sala_id','=','tipos_salas.id')
				->where('campus.nombre', 'like' , '%'.$request->get('name').'%')
				->orWhere('salas.nombre','like', '%'.$request->get('name').'%')
				->orWhere('tipos_salas.nombre','like', '%'.$request->get('name').'%')
				->select('salas.*','campus.nombre as campus','tipos_salas.nombre as tipo')
				->paginate();	

		return view('Encargado/salas/salas_list',compact('datos_salas'));
		}

		else
		{

			return redirect()->action('EncargadoController@get_salas');
		}
	}


	public function get_ingreso()
	{
		$id_c= 1;
		$id_a= 2;
		$id_e= 3;
		$id_d= 4;
		return view('Encargado/salas/ingreso_index',compact('id_c','id_a','id_e','id_d'));
	}



	

/*----------------------------------------------E S T U D I A N T E-------------------------------------------------*/


	public function get_create(Request $request)
	{
	
		if($request->get('id')==1)
		{
			$asignaturas = Asignaturas::where('departamento_id', '=', $request->get('departamentos'))->lists('nombre','id');
			
			$docentes = Docentes::where('departamento_id', '=', $request->get('departamentos'))->lists('apellidos','id');

			return view('Encargado/create_curso',compact('asignaturas','docentes'));
		}
		if($request->get('id')==2)
		{
			$departamentos = Departamentos::paginate()->lists('nombre','id');
			return view('Encargado/asignaturas/create_asignatura',compact('departamentos'));
		}	
		if($request->get('id')==3)
		{
			$carreras = Carreras::paginate()->lists('nombre','id');
			return view('Encargado/estudiantes/create_estudiante',compact('carreras'));
		}
		if($request->get('id')==4)
		{
			$departamentos = Departamentos::paginate()->lists('nombre','id');
			return view('Encargado/docentes/create_docente',compact('departamentos'));
		}


		
	}



		public function post_storeEstudiante()
	{
		
		$estudiante = new Estudiantes();
		$estudiante->fill(\Request::all());
		$estudiante->save();

		Session::flash('message', 'El estudiante fue creado exitosamente!');
		return redirect()->action('EncargadoController@get_estudiantes');
	
	}


	public function get_estudiantes()
	{
		$datos_estudiantes = Estudiantes::join('carreras','estudiantes.carrera_id','=','carreras.id')
									->select('estudiantes.*','carreras.nombre as carrera')
									->paginate();

		return view('Encargado/estudiantes/estudiantes_list',compact('datos_estudiantes'));
	}



	public function get_editEstudiante(Request $request)
	{
		
		$estudianteEditable = Estudiantes::findOrFail($request->get('id'));

		$carreras = Carreras::paginate()->lists('nombre','id');

		$id = $request->get('id');

		return view('Encargado/estudiantes/edit_estudiante', compact('estudianteEditable','id','carreras'));
	
	}



	public function put_updateEstudiante(Request $request)
	{

		$estudiante = Estudiantes::findOrFail($request->get('id'));
		$estudiante->fill(\Request::all());
		$estudiante->save();
		
		Session::flash('message', 'El estudiante '.$estudiante->nombres.' '.$estudiante->apellidos.' fue editado exitosamente!');

		return redirect()->action('EncargadoController@get_estudiantes');
	}



	public function delete_destroyEstudiante(Request $request)
	{

		$estudiante = Estudiantes::findOrFail($request->get('id'));

		$estudiante->delete();


		Session::flash('message', 'El estudiante '.$estudiante->nombres.' '.$estudiante->apellidos.' fue eliminado exitosamente!');

		return redirect()->action('EncargadoController@get_estudiantes');
		
	}


	public function get_searchEstudiante(Request $request)
		{
		
			if(trim($request->get('name')) != "")
			{

			 $datos_estudiantes = Estudiantes::join('carreras','estudiantes.carrera_id','=','carreras.id')
			->where('estudiantes.rut', '=' , $request->get('name'))
			->select('estudiantes.*','carreras.nombre as carrera')
			->paginate();

			return view('Encargado/estudiantes/estudiantes_list',compact('datos_estudiantes'));
			}

			else
			{

		 	return redirect()->action('EncargadoController@get_estudiantes');

			}
		}


	public function get_carreras()
	{
		$carreras = Carreras::all()->lists('nombre','id');
		return view('Encargado/estudiantes/upload_estudiantes',compact('carreras'));
	}


	public function post_uploadEstudiantes(Request $request)
	{

	    // dd($request);
		   $file = $request->file('file');
	    //dd($file);
	       $nombre = $file->getClientOriginalName();

	       \Storage::disk('local')->put($nombre,  \File::get($file));

			$carrera = $request->get('carrera');

			\Excel::load($nombre,function($archivo) use ($carrera)
			{

				$result = $archivo->get();

				foreach($result as $key => $value)
				{
					$estudiantes = new Estudiantes();
					$estudiantes->fill(['carrera_id' => $carrera,'rut' => $value->rut,'nombres' =>$value->nombres,'apellidos' => $value->apellidos,'email' =>$value->email]);
					$estudiantes->save();

				}

			})->get();
			Session::flash('message', 'Los alumnos fueron agregados exitosamente!');

	       return redirect()->action('EncargadoController@get_estudiantes');
	}
/*----------------------------------------D O C E N T E S----------------------------------------------------------*/

	public function get_docentes()
	{
			
		$datos_docentes = Docentes::join('departamentos','docentes.departamento_id','=','departamentos.id')
						->select('docentes.*','departamentos.nombre as departamento')
						->paginate();

		return view('Encargado/docentes/docentes_list',compact('datos_docentes'));
	}


	public function get_createDocente()
	{

		$departamentos = Departamentos::paginate()->lists('nombre','id');

		return view('Encargado/docentes/create_docente',compact('departamentos'));
	}


	public function post_storeDocente()
	{
		
		$docente= new Docentes();
		$docente->fill(\Request::all());
		$docente->save();

		Session::flash('message', 'El docente '.$docente->nombres.' '.$docente->apellidos.' fue creado exitosamente!');

		return redirect()->action('EncargadoController@get_docentes');
	
	}




	public function get_editDocente(Request $request)
	{
		
		$docenteEditable = Docentes::findOrFail($request->get('id'));

		$departamentos = Departamentos::paginate()->lists('nombre','id');

		$id = $request->get('id');

		return view('Encargado/docentes/edit_docente', compact('docenteEditable','id','departamentos'));
	
	}



	public function put_updateDocente(Request $request)
	{

		$docente = Docentes::findOrFail($request->get('id'));
		$docente->fill(\Request::all());
		$docente->save();
		
		Session::flash('message', 'El docente '.$docente->nombres.' '.$docente->apellidos.' fue editado exitosamente!');

		return redirect()->action('EncargadoController@get_docentes');
	}


	public function delete_destroyDocente(Request $request)
	{

		$docente = Docentes::findOrFail($request->get('id'));

		$docente->delete();


		Session::flash('message', 'El docente '.$docente->nombres.' '.$docente->apellidos.' fue eliminado exitosamente!');

		return redirect()->action('EncargadoController@get_docentes');
		
	}

	public function get_searchDocente(Request $request)
		{
		
			if(trim($request->get('name')) != "")
			{

			 $datos_docentes = Docentes::join('departamentos','docentes.departamento_id','=','departamentos.id')
			->where('docentes.rut', '=' , $request->get('name'))
			->select('docentes.*','departamentos.nombre as departamento')
			->paginate();

			return view('Encargado/docentes/docentes_list',compact('datos_docentes'));
			}

			else
			{

		 	return redirect()->action('EncargadoController@get_docentes');

			}
		}


	public function get_departamentos()
	{
		$departamentos = Departamentos::all()->lists('nombre','id');
		return view('Encargado/docentes/upload_docentes',compact('departamentos'));
	}

	public function post_uploadDocentes(Request $request)
	{

	    // dd($request);
		   $file = $request->file('file');
	    //dd($file);
	       $nombre = $file->getClientOriginalName();

	       \Storage::disk('local')->put($nombre,  \File::get($file));

			$departamento = $request->get('departamento');

			\Excel::load($nombre,function($archivo) use ($departamento)
			{

				$result = $archivo->get();

				foreach($result as $key => $value)
				{
					$docentes = new Docentes();
					$docentes->fill(['departamento_id' => $departamento,'rut' => $value->rut,'nombres' =>$value->nombres,'apellidos' => $value->apellidos]);
					$docentes->save();

				}

			})->get();
			Session::flash('message', 'Los docentes fueron agregados exitosamente!');

	       return redirect()->action('EncargadoController@get_docentes');
	}

/*---------------------------------------C U R S O S---------------------------------------------------------------*/


	public function get_departamento()
	{
		$departamentos = Departamentos::paginate()->lists('nombre','id');
		return view('Encargado/cursos/select_departamento',compact('departamentos'));
	}



	public function get_cursos()
	{
		$datos_cursos = Cursos::join('asignaturas', 'cursos.asignatura_id', '=','asignaturas.id')
				->join('docentes','cursos.docente_id','=','docentes.id')
				->select('cursos.*','asignaturas.nombre','docentes.nombres','docentes.apellidos','docentes.rut')
				->paginate();


		return view('Encargado/cursos/cursos_list',compact('datos_cursos'));
	}


	public function get_createCurso(Request $request)
	{

		    $asignaturas = Asignaturas::where('departamento_id', '=', $request->get('departamentos'))->lists('nombre','id');
			
			$docentes = Docentes::where('departamento_id', '=', $request->get('departamentos'))->lists('apellidos','id');

			return view('Encargado/cursos/create_curso',compact('asignaturas','docentes'));
	}
	

	public function post_storeCurso()
	{
	
		$curso = new Cursos();
		$curso->fill(\Request::all());
		$curso->save();

		Session::flash('message', 'El curso fue creado exitosamente!');

		return redirect()->action('EncargadoController@get_cursos');
	}



		public function get_editCurso(Request $request)
	{
		
		$cursoEditable = Cursos::findOrFail($request->get('id'));

		$id = $request->get('id');

		$asignaturas = Asignaturas::paginate()->lists('nombre','id');

		$docentes = Docentes::paginate()->lists('apellidos','id');

		return view('Encargado/cursos/edit_curso', compact('cursoEditable','id','asignaturas','docentes'));
	
	}



	public function put_updateCurso(Request $request)
	{
	
		$curso = Cursos::findOrFail($request->get('id'));
		$curso->fill(\Request::all());
		$curso->save();

		Session::flash('message','El curso fue editado exitosamente');

		return redirect()->action('EncargadoController@get_cursos');
	}

	public function delete_destroyCurso(Request $request)
	{

		$curso = Cursos::findOrFail($request->get('id'));

		//$curso_nombre = Asignaturas::where('id','=',$curso->asignatura_id)->select('nombre')->get();

		$curso->delete();


		Session::flash('message','El curso fue eliminado exitosamente');

		return redirect()->action('EncargadoController@get_cursos');
		
	}

	public function get_searchCurso(Request $request)
		{
		
			if(trim($request->get('name')) != "")
			{

			 $datos_cursos = Cursos::join('docentes','cursos.docente_id','=','docentes.id')
			 ->join('asignaturas','cursos.asignatura_id','=','asignaturas.id')
			->where('docentes.nombres', 'like' , '%'.$request->get('name').'%')
			->orWhere('docentes.apellidos', 'like' , '%'.$request->get('name').'%')
			->orWhere('asignaturas.nombre','like','%'.$request->get('name').'%')
			->select('cursos.*','asignaturas.nombre','docentes.nombres','docentes.apellidos')
			->paginate();

			return view('Encargado/cursos/cursos_list',compact('datos_cursos'));
			}

			else
			{

		 	return redirect()->action('EncargadoController@get_cursos');

			}
		}

/*--------------------------------------H O R A R I O S--------------------------------------------------------------------*/


	public function get_horarios()
	{

		$datos_horarios  = Horarios::join('salas','horarios.sala_id','=','salas.id')
				->join('periodos', 'horarios.periodo_id', '=','periodos.id')
				->join('cursos', 'horarios.curso_id', '=','cursos.id')
				->join('asignaturas','cursos.asignatura_id','=','asignaturas.id')
				->join('dias','horarios.dia_id','=','dias.id')
				->join('docentes','cursos.docente_id','=','docentes.id')
				->select('dias.nombre as dia','salas.nombre as sala','periodos.bloque','periodos.inicio','periodos.fin','asignaturas.nombre','horarios.id as horario_id','docentes.*')
				->paginate();


		return view('Encargado/horarios_list',compact('datos_horarios'));
	}

	public function get_searchHorario(Request $request)
	{
	
		if(trim($request->get('name')) != "")
		{
			
		$datos_horarios  = Horarios::join('salas','horarios.sala_id','=','salas.id')
				->join('periodos', 'horarios.periodo_id', '=','periodos.id')
				->join('cursos', 'horarios.curso_id', '=','cursos.id')
				->join('asignaturas','cursos.asignatura_id','=','asignaturas.id')
				->join('dias','horarios.dia_id','=','dias.id')
				->join('docentes','cursos.docente_id','=','docentes.id')
				->where('asignaturas.nombre', 'like' , '%'.$request->get('name').'%')
				->select('dias.nombre as dia','salas.nombre as sala','periodos.bloque','periodos.inicio','periodos.fin','asignaturas.nombre','horarios.id as horario_id','docentes.*')
				->paginate();

		return view('Encargado/horarios_list',compact('datos_horarios'));

		}

		else
		{

			return redirect()->action('EncargadoController@get_horarios');
		}

	}


	public function get_editHorario(Request $request)
	{

		$horarioEditable = Horarios::findOrFail($request->get('id'));

		$periodos = Periodos::paginate()->lists('bloque','id');

		$dias = Dias::paginate()->lists('nombre','id');

		$salas = Salas::paginate()->lists('nombre','id');

		
		$curso = Cursos::join('asignaturas','cursos.asignatura_id','=','asignaturas.id')
		->where('cursos.id','=',$horarioEditable->curso_id)
		->select('asignaturas.nombre')
		->paginate();


		$id = $request->get('id');

		$curso_id = $horarioEditable->curso_id;

		return view('Encargado/edit_horario', compact('horarioEditable','periodos','dias','salas','curso','curso_id','id'));

	}


	public function put_updateHorario(Request $request)
	{

		$horario = Horarios::findOrFail($request->get('id'));
		$horario->fill(\Request::all());
		$horario->save();
		
		Session::flash('message', 'El horario fue editado exitosamente!');

		return redirect()->action('EncargadoController@get_horarios');
	}



	public function delete_destroyHorario(Request $request)
	{
		$horario = Horarios::findOrFail($request->get('id'));

		$horario->delete();


		Session::flash('message', 'El horario fue eliminado exitosamente!');

		return redirect()->action('EncargadoController@get_horarios');
	}


/*--------------------------------------A S I G N A T U R A S---------------------------------------------------------*/
			
	public function post_storeAsignatura()
	{
		
		$asignatura = new Asignaturas();
		$asignatura->fill(\Request::all());
		$asignatura->save();

		Session::flash('message', 'La asignatura fue creada exitosamente!');
		return redirect()->action('EncargadoController@get_asignaturas');
	
	}



	public function get_asignaturas()
	{
		$datos_asignaturas = Asignaturas::join('departamentos','asignaturas.departamento_id','=','departamentos.id')
										  ->select('asignaturas.*','departamentos.nombre as departamento')
										  ->paginate();

		return view('Encargado/asignaturas/asignaturas_list',compact('datos_asignaturas'));
	}


	public function get_searchAsignatura(Request $request)
	{
	
		if(trim($request->get('name')) != "")
		{

		$datos_asignaturas = Asignaturas::join('departamentos','asignaturas.departamento_id','=','departamentos.id')
				->where('asignaturas.nombre', 'like' , '%'.$request->get('name').'%')
				->orWhere('departamentos.nombre','like', '%'.$request->get('name').'%')
				->orWhere('asignaturas.codigo','like','%'.$request->get('name').'%')
				->select('asignaturas.*','departamentos.nombre as departamento')
				->paginate();	

		return view('Encargado/asignaturas/asignaturas_list',compact('datos_asignaturas'));
		}

		else
		{

	 	return redirect()->action('EncargadoController@get_asignaturas');

		}
	}


	public function get_editAsignatura(Request $request)
	{
		
		$asignaturaEditable = Asignaturas::findOrFail($request->get('id'));

		$id = $request->get('id');

		$departamentos = Departamentos::paginate()->lists('nombre','id');

		return view('Encargado/asignaturas/edit_asignatura', compact('asignaturaEditable','id','departamentos'));
	
	}



	public function put_updateAsignatura(Request $request)
	{
	
		$asignatura = Asignaturas::findOrFail($request->get('id'));
		$asignatura->fill(\Request::all());
		$asignatura->save();
		
		return redirect()->action('EncargadoController@get_asignaturas');
	}



	public function delete_destroyAsignatura(Request $request)
		{

			$asignatura = Asignaturas::findOrFail($request->get('id'));

			$asignatura->delete();


			Session::flash('message','La asignatura fue eliminada');

			return redirect()->action('EncargadoController@get_asignaturas');
			
		}

	public function get_depto()
	{
		$departamentos = Departamentos::all()->lists('nombre','id');
		return view('Encargado/asignaturas/upload_asignaturas',compact('departamentos'));
	}


	public function post_uploadAsignaturas(Request $request)
	{
	 //dd($request);
	     
		   $file = $request->file('file');
	    
	       $nombre = $file->getClientOriginalName();

	       \Storage::disk('local')->put($nombre,  \File::get($file));

			$departamento = $request->get('departamento');

			\Excel::load($nombre,function($archivo) use ($departamento)
			{

				$result = $archivo->get();

				foreach($result as $key => $value)
				{
					$asignatura = new Asignaturas();
					$asignatura->fill(['departamento_id' => $departamento,'codigo' => $value->codigo,'nombre' =>$value->nombre,'descripcion' => $value->descripcion]);
					$asignatura->save();

				}

			})->get();
			Session::flash('message', 'Las asignaturas fueron agregadas exitosamente!');

	       return redirect()->action('EncargadoController@get_asignaturas');
	}

/*---------------------------------------D O W N L O A D----------------------------------------------------------*/

	public function get_download()
	{
		$es = Estudiantes::join('carreras','estudiantes.carrera_id','=','carreras.id')
							->select('estudiantes.*','carreras.nombre','carreras.codigo')
							->get();
		//dd($es);

		\Excel::create('Estudiantes',function($excel) use ($es)
		{
			$excel->sheet('Sheetname',function($sheet) use ($es)
			{
				$data=[];

				array_push($data, array('CARRERA','RUT','NOMBRES','APELLIDOS','EMAIL'));

				foreach($es as $key => $e)
				{
					
					array_push($data, array($e->codigo,$e->rut,$e->nombres,$e->apellidos,$e->email));

				}		
				$sheet->fromArray($data,null, 'A1', false,false);
			
			});
			
		})->download('xlsx');

			dd('++++');

		return ('bajado');
	}



}
