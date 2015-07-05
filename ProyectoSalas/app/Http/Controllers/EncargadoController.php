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


	public function get_cursos()
	{
		$datos_cursos = Cursos::join('asignaturas', 'cursos.asignatura_id', '=','asignaturas.id')
				->join('docentes','cursos.docente_id','=','docentes.id')
				->select('cursos.*','asignaturas.nombre','docentes.nombres','docentes.apellidos','docentes.rut')
				->paginate();


		return view('Encargado/cursos_list',compact('datos_cursos'));
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

		return view('Encargado/cursos_list',compact('datos_cursos'));
		}

		else
		{

			return redirect()->action('EncargadoController@get_cursos');
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

		return view('Encargado/add',compact('datos_curso','periodos','salas','curso_id','dias'));
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


	public function get_salas(Request $request)
	{
		$salas = Salas::where('campus_id','=',$request->get('select_campus'))->lists('nombre','id');

	
		return view('Encargado/select_sala',compact('salas'));

	}

	public function get_edit(Request $request)
	{

		$datos_sala = Salas::findOrFail($request->get('id_sala'));

		$id = $request->get('id_sala');

		return view('Encargado/edit_sala',compact('datos_sala','id'));
	}


	public function put_update(Request $request)
	{
	
		$sala = Salas::findOrFail($request->get('id'));
		$sala->fill(\Request::all());
		$sala->save();
		Session::flash('message', 'La sala fue modificada exitosamente!');
		return view('Encargado/indexEncargado');
	}



	public function get_ingreso()
	{
		$id_c= 1;
		$id_a= 2;
		$id_e= 3;
		return view('Encargado/ingreso_index',compact('id_c','id_a','id_e'));
	}



	public function get_departamento(Request $request)
	{
		$departamentos = Departamentos::paginate()->lists('nombre','id');
		$id = $request->get('id');
		return view('Encargado/select_departamento',compact('departamentos','id'));
	}


	public function get_escuela(Request $request)
	{

		$escuela = Escuelas::paginate()->lists('nombre','id');
		$id = $request->get('id');
		return view('Encargado/select_escuela',compact('escuela','id'));
	}



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
			return view('Encargado/create_asignatura',compact('departamentos'));
		}	
		if($request->get('id')==3)
		{
			$carreras = Carreras::where('escuela_id', '=', $request->get('escuela'))->lists('nombre','id');
			return view('Encargado/create_estudiante',compact('carreras'));
		}

		
	}


	public function post_store()
	{
	
		$curso = new Cursos();
		$curso->fill(\Request::all());
		$curso->save();

		Session::flash('message', 'El curso fue creado exitosamente!');
		return redirect()->action('EncargadoController@getIndex');
	
	}

		public function post_storeAsignatura()
	{
		
		$asignatura = new Asignaturas();
		$asignatura->fill(\Request::all());
		$asignatura->save();

		Session::flash('message', 'La asignatura fue creada exitosamente!');
		return redirect()->action('EncargadoController@getIndex');
	
	}


		public function post_storeEstudiante()
	{
		
		$estudiante = new Estudiantes();
		$estudiante->fill(\Request::all());
		$estudiante->save();

		Session::flash('message', 'El estudiante fue creado exitosamente!');
		return redirect()->action('EncargadoController@getIndex');
	
	}




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
				->orWhere('docentes.nombres','like', '%'.$request->get('name').'%')
				->orWhere('docentes.apellidos','like', '%'.$request->get('name').'%')
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
	public function get_asignaturas()
	{
		$datos_asignaturas = Asignaturas::join('departamentos','asignaturas.departamento_id','=','departamentos.id')
										  ->select('asignaturas.*','departamentos.nombre as departamento')
										  ->paginate();

		return view('Encargado/asignaturas_list',compact('datos_asignaturas'));
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

		return view('Encargado/asignaturas_list',compact('datos_asignaturas'));
		}

		else
		{

	 	return redirect()->action('EncargadoController@get_asignaturas');

		}
	}





/*---------------------------------------------U P L O A D--------------------------------------------------------*/

public function post_save(Request $request)
{
 //dd($request);
       //obtenemos el campo file definido en el formulario

		$file = $request->file('file');
       
       //obtenemos el nombre del archivo
    
       $nombre = $file->getClientOriginalName();

       //indicamos que queremos guardar un nuevo archivo en el disco local
       \Storage::disk('local')->put($nombre,  \File::get($file));

		Session::flash('message', 'Las asignaturas fueron agregadas exitosamente!');

       return redirect()->action('EncargadoController@get_depto');
}


/*---------------------------------------I M P O R T--------------------------------------------------------------*/

	public function get_depto()
	{
		$departamentos = Departamentos::all()->lists('nombre','id');
		return view('Encargado/upload_asignaturas',compact('departamentos'));
	}



	public function put_uploadAsignaturas(Request $request)
	{
	

		$departamento = $request->get('departamento');

		\Excel::load('/asignaturasINFO.xlsx',function($archivo) use ($departamento)
		{

			$result = $archivo->get();

			foreach($result as $key => $value)
			{
				$asignatura = new Asignaturas();
				$asignatura->fill(['departamento_id' => $departamento,'codigo' => $value->codigo,'nombre' =>$value->nombre,'descripcion' => $value->descripcion]);
				$asignatura->save();

			}

		})->get();

		Session::flash('message', 'Las asignaturas fueron creadas exitosamente!');

		return redirect()->action('EncargadoController@getIndex');
	}



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
