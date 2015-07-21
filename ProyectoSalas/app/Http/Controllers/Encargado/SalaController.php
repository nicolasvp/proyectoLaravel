<?php namespace App\Http\Controllers\Encargado;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


use App\Models\Sala;
use App\Models\Curso;
use App\Models\Periodo;
use App\Models\Horario;
use App\Models\Campus;

use Carbon\Carbon;



class SalaController extends Controller {


	public function getIndex()
	{

		return view('Encargado/salas/ingreso_index');
	}


	public function get_curso()
	{

		$datos_cursos = Curso::join('asignaturas','cursos.asignatura_id','=','asignaturas.id')
		->join('docentes','cursos.docente_id','=','docentes.id')
		->select('cursos.*','docentes.nombres','docentes.apellidos','docentes.rut','asignaturas.nombre')
		->paginate();

		return view('Encargado/salas/cursos',compact('datos_cursos'));
	}



	public function get_campus(Request $request)
	{
		$campus = Campus::all()->lists('nombre','id');
		$id_curso = $request->get('id_curso');
		return view('Encargado/salas/campus',compact('campus','id_curso'));
	}

	public function get_datos(Request $request)
	{

		$datos_curso = Curso::join('asignaturas', 'cursos.asignatura_id', '=','asignaturas.id')
				->join('docentes','cursos.docente_id','=','docentes.id')
				->where('cursos.id', '=', $request->get('id_curso'))
				->select('cursos.*','asignaturas.nombre','docentes.nombres','docentes.apellidos','docentes.rut')
				->paginate();


		$periodos = Periodo::get()->lists('bloque','id');
		
		$salas = Sala::where('campus_id','=',$request->get('campus'))->get()->lists('nombre','id');

		$curso_id = $request->get('id_curso');


		return view('Encargado/salas/create',compact('datos_curso','periodos','salas','curso_id'));
	}




	public function post_store(Request $request)
	{
	
		//	dd($request);
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
				//echo "lunes: ".$lunes."<br>";
			}
			if($request->martes)
			{
				$martes = new Carbon('this tuesday');
				if($martes <= $termino)
				{
				$mar = new Horario();
				$mar->fill(['fecha' => $martes,'sala_id' => $request->get('sala'),'periodo_id' => $request->get('periodo'),'curso_id' => $request->get('curso')]);
				$mar->save();
				//echo "martes: ".$martes."<br>";
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
				//echo "miercoles: ".$miercoles."<br>";
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
				//echo "jueves: ".$jueves."<br>";
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
				//echo "viernes: ".$viernes."<br>";
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
				//echo "sabado: ".$sabado."<br>";
				}
			}

			$inicio->addWeek(1);
			
		}	

		Session::flash('message', 'La sala fue asignada exitosamente!');

		return redirect()->action('Encargado\HorarioController@getIndex');

	}






	public function get_searchCurso(Request $request)
	{
	
		if(trim($request->get('name')) != "")
		{

		$datos_cursos = Curso::join('asignaturas', 'cursos.asignatura_id', '=','asignaturas.id')
				->join('docentes','cursos.docente_id','=','docentes.id')
				->where('asignaturas.nombre', 'like' , '%'.$request->get('name').'%')
				->orWhere('docentes.rut','=',(integer) $request->get('name'))
				->orWhere('docentes.nombres','like', '%'.$request->get('name').'%')
				->orWhere('docentes.apellidos','like', '%'.$request->get('name').'%')
				->select('cursos.*','asignaturas.nombre','docentes.nombres','docentes.apellidos','docentes.rut')
				->paginate();	

		return view('Encargado/salas/cursos',compact('datos_cursos'));
		}

		else
		{

			return redirect()->action('Encargado\SalaController@get_curso');
		}
	}






	public function get_salas()
	{
		$datos_salas = Sala::join('campus','salas.campus_id','=','campus.id')
		->join('tipos_salas','salas.tipo_sala_id','=','tipos_salas.id')
		->select('salas.*','campus.nombre as campus','tipos_salas.nombre as tipo')
		->paginate();

	
		return view('Encargado/salas/salas',compact('datos_salas'));

	}

	public function get_edit(Request $request)
	{

		$datos_sala = Sala::findOrFail($request->get('id_sala'));

		$id = $request->get('id_sala');

		return view('Encargado/salas/edit',compact('datos_sala','id'));
	}


	public function put_update(Requests \EditSalaRequest $request)
	{
	
		$sala = Sala::findOrFail($request->get('id'));
		$sala->fill(\Request::all());
		$sala->save();
		Session::flash('message', 'La sala '.$sala->nombre.' fue modificada exitosamente!');

		return redirect()->action('Encargado\SalaController@get_salas');
	}



		public function get_search(Request $request)
	{
	
		if(trim($request->get('name')) != "")
		{

		$datos_salas = Sala::join('campus', 'salas.campus_id', '=','campus.id')
				->join('tipos_salas','salas.tipo_sala_id','=','tipos_salas.id')
				->where('campus.nombre', 'like' , '%'.$request->get('name').'%')
				->orWhere('salas.nombre','like', '%'.$request->get('name').'%')
				->orWhere('tipos_salas.nombre','like', '%'.$request->get('name').'%')
				->select('salas.*','campus.nombre as campus','tipos_salas.nombre as tipo')
				->paginate();	

		return view('Encargado/salas/salas',compact('datos_salas'));
		}

		else
		{

			return redirect()->action('Encargado\SalaController@get_salas');
		}
	}











	






}
