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
use App\Models\Rol_usuario;

use Carbon\Carbon;



class SalaController extends Controller {


	public function getIndex()
	{

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre'); 

		return view('Encargado/salas/ingreso_index',compact('var'));
	}


	public function get_curso()
	{

		$datos_cursos = Curso::join('asignaturas','cursos.asignatura_id','=','asignaturas.id')
		->join('docentes','cursos.docente_id','=','docentes.id')
		->select('cursos.*','docentes.nombres','docentes.apellidos','docentes.rut','asignaturas.nombre')
		->paginate();

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre'); 

		return view('Encargado/salas/cursos',compact('datos_cursos','var'));
	}



	public function get_campus(Request $request)
	{
		$campus = Campus::all()->lists('nombre','id');
		$id_curso = $request->get('id_curso');

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre'); 

		return view('Encargado/salas/campus',compact('campus','id_curso','var'));
	}


	public function get_datos(Requests \SelectCampusRequest $request)
	{

		$datos_curso = Curso::join('asignaturas', 'cursos.asignatura_id', '=','asignaturas.id')
				->join('docentes','cursos.docente_id','=','docentes.id')
				->where('cursos.id', '=', $request->get('id_curso'))
				->select('cursos.*','asignaturas.nombre','docentes.nombres','docentes.apellidos','docentes.rut')
				->paginate();


		$periodos = Periodo::get()->lists('bloque','id');
		
		$salas = Sala::where('campus_id','=',$request->get('campus'))->get()->lists('nombre','id');

		$curso_id = $request->get('id_curso');

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre'); 
 
		return view('Encargado/salas/create',compact('datos_curso','periodos','salas','curso_id','var'));
	}




	public function post_store(Requests \CreateAsignarSalaRequest $request)
	{


		if(!$request->lunes && !$request->martes && !$request->miercoles && !$request->jueves && !$request->viernes && !$request->sabado)
		{
				Session::flash('message', 'Debe seleccionar al menos un día');

				return redirect()->back()->withInput(\Request::all());
		}

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

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre'); 

		return view('Encargado/salas/cursos',compact('datos_cursos','var'));
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

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre'); 
	
		return view('Encargado/salas/salas',compact('datos_salas','var'));

	}

	public function get_edit(Request $request)
	{

		$datos_sala = Sala::findOrFail($request->get('id_sala'));

		$id = $request->get('id_sala');

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre'); 

		return view('Encargado/salas/edit',compact('datos_sala','id','var'));
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

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre'); 


		return view('Encargado/salas/salas',compact('datos_salas','var'));
		}

		else
		{

			return redirect()->action('Encargado\SalaController@get_salas');
		}
	}

	public function get_upload()
	{

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre');	

		return view('Encargado/salas/upload',compact('var'));
	}


	public function post_upload(Requests \FechaHorarioUploader $request)
	{

		 if(is_null($request->file('file')))
	     {
	     	Session::flash('message', 'Debes seleccionar un archivo.');

			return redirect()->back();
		 }

		    if(!$request->lunes && !$request->martes && !$request->miercoles && !$request->jueves && !$request->viernes && !$request->sabado)
			{
				Session::flash('message', 'Debe seleccionar al menos un día');

				return redirect()->back();
			}

		   $file = $request->file('file');
	    
	       $nombre = $file->getClientOriginalName();

	       \Storage::disk('local')->put($nombre,  \File::get($file));


			\Excel::load('/storage/app/'.$nombre,function($archivo) use ($request)
			{
				$result = $archivo->get();


				foreach($result as $key => $value)
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
								$sala_id = Sala::where('id','=',$value->sala)->first();

								if(is_null($sala_id))
									continue;

								$periodo_id = Periodo::where('id','=',$value->periodo)->first();

								if(is_null($periodo_id))
									continue;

								$curso_id = Curso::where('id','=',$value->curso)->first();

								if(is_null($curso_id))
									continue;

								$tupla = Horario::where('fecha','=',$lunes)->where('sala_id','=',$value->sala)->where('periodo_id','=',$value->periodo)->first();

								if(is_null($tupla))
								{
									$lun = new Horario();
									$lun->fill(['fecha' => $lunes,'sala_id' => $value->sala,'periodo_id' => $value->periodo,'curso_id' => $value->curso]);
									$lun->save();
								}
							}

						}
						if($request->martes)
						{
							$martes = new Carbon('this tuesday');

							if($martes <= $termino)
							{
								$sala_id = Sala::where('id','=',$value->sala)->first();

								if(is_null($sala_id))
									continue;

								$periodo_id = Periodo::where('id','=',$value->periodo)->first();

								if(is_null($periodo_id))
									continue;

								$curso_id = Curso::where('id','=',$value->curso)->first();

								if(is_null($curso_id))
									continue;

								$tupla = Horario::where('fecha','=',$martes)->where('sala_id','=',$value->sala)->where('periodo_id','=',$value->periodo)->first();

								if(is_null($tupla))
								{								
									$mar = new Horario();
									$mar->fill(['fecha' => $martes,'sala_id' => $value->sala,'periodo_id' => $value->periodo,'curso_id' => $value->curso]);
									$mar->save();
								}
							}
						}
						if($request->miercoles)
						{
							$miercoles = new Carbon('this wednesday');

							if($miercoles <= $termino)
							{
								$sala_id = Sala::where('id','=',$value->sala)->first();

								if(is_null($sala_id))
									continue;

								$periodo_id = Periodo::where('id','=',$value->periodo)->first();

								if(is_null($periodo_id))
									continue;

								$curso_id = Curso::where('id','=',$value->curso)->first();

								if(is_null($curso_id))
									continue;

								$tupla = Horario::where('fecha','=',$miercoles)->where('sala_id','=',$value->sala)->where('periodo_id','=',$value->periodo)->first();

								if(is_null($tupla))
								{

									$mier = new Horario();
									$mier->fill(['fecha' => $miercoles,'sala_id' => $value->sala,'periodo_id' => $value->periodo,'curso_id' => $value->curso]);
									$mier->save();
								}
							}
						}
						if($request->jueves)
						{
							$jueves = new Carbon('this thursday');

							if($jueves <= $termino)
							{
								$sala_id = Sala::where('id','=',$value->sala)->first();

								if(is_null($sala_id))
									continue;

								$periodo_id = Periodo::where('id','=',$value->periodo)->first();

								if(is_null($periodo_id))
									continue;

								$curso_id = Curso::where('id','=',$value->curso)->first();

								if(is_null($curso_id))
									continue;

								$tupla = Horario::where('fecha','=',$jueves)->where('sala_id','=',$value->sala)->where('periodo_id','=',$value->periodo)->first();

								if(is_null($tupla))
								{

									$jue = new Horario();
									$jue->fill(['fecha' => $jueves,'sala_id' => $value->sala,'periodo_id' => $value->periodo,'curso_id' => $value->curso]);
									$jue->save();
								}	
							}
						}
						if($request->viernes)
						{
							$viernes = new Carbon('this friday');

							if($viernes <= $termino)
							{

								$sala_id = Sala::where('id','=',$value->sala)->first();

								if(is_null($sala_id))
									continue;

								$periodo_id = Periodo::where('id','=',$value->periodo)->first();

								if(is_null($periodo_id))
									continue;

								$curso_id = Curso::where('id','=',$value->curso)->first();

								if(is_null($curso_id))
									continue;

								$tupla = Horario::where('fecha','=',$viernes)->where('sala_id','=',$value->sala)->where('periodo_id','=',$value->periodo)->first();

								if(is_null($tupla))
								{

								$vier = new Horario();
								$vier->fill(['fecha' => $viernes,'sala_id' => $value->sala,'periodo_id' => $value->periodo,'curso_id' => $value->curso]);
								$vier->save();
								}
							}
						}
						if($request->sabado)
						{
							$sabado = new Carbon('this saturday');

							if($sabado <= $termino)
							{

								$sala_id = Sala::where('id','=',$value->sala)->first();

								if(is_null($sala_id))
									continue;

								$periodo_id = Periodo::where('id','=',$value->periodo)->first();

								if(is_null($periodo_id))
									continue;

								$curso_id = Curso::where('id','=',$value->curso)->first();

								if(is_null($curso_id))
									continue;

								$tupla = Horario::where('fecha','=',$sabado)->where('sala_id','=',$value->sala)->where('periodo_id','=',$value->periodo)->first();

								if(is_null($tupla))
								{	
									$sab = new Horario();
									$sab->fill(['fecha' => $sabado,'sala_id' => $value->sala,'periodo_id' => $value->periodo,'curso_id' => $value->curso]);
									$sab->save();
								}
							}
						}

						$inicio->addWeek(1);
					
					}
					

				}
						
	
	       			
			})->get();

			\Storage::delete($nombre);
		
		    return redirect()->action('Encargado\HorarioController@getIndex');
	
	}





}
