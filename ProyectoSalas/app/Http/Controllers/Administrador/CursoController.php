<?php namespace App\Http\Controllers\Administrador;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use Request;
use Illuminate\Support\Facades\Session;


use App\Models\Curso;
use App\Models\Carrera;
use App\Models\Departamento;
use App\Models\Asignatura;
use App\Models\Docente;
use App\Models\Rol_usuario;





class CursoController extends Controller {


	protected $layout='layouts.master';




	public function getIndex(Request $request)
	{

		$datos_cursos = Curso::join('asignaturas', 'cursos.asignatura_id', '=','asignaturas.id')
				->join('docentes','cursos.docente_id','=','docentes.id')
				->select('cursos.*','asignaturas.nombre','docentes.nombres','docentes.apellidos','docentes.rut')
				->paginate();

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/cursos/list',compact('datos_cursos','var'));
	}


	public function get_departamento()
	{
		$departamentos = Departamento::paginate()->lists('nombre','id');

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/cursos/select_departamento',compact('departamentos','var'));
	}


	public function get_create(Requests \SelectDeptoRequest $request)
	{

			$departamento = $request->get('departamento');

		    $asignaturas = Asignatura::where('departamento_id', '=', $request->get('departamento'))->lists('nombre','id');
			
			$docentes = Docente::where('departamento_id', '=', $request->get('departamento'))->lists('apellidos','id');

			$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

			return view('Administrador/cursos/create',compact('asignaturas','docentes','departamento','var'));
	}
	

	public function post_store(Requests \CreateCursoRequest $request)
	{
	
		$curso = new Curso();
		$curso->fill(['asignatura_id' => $request->get('asignatura'), 'docente_id' => $request->get('docente'),
			'semestre' => $request->get('semestre'), 'anio' => $request->get('año'), 'seccion' => $request->get('seccion')]);
		$curso->save();

		Session::flash('message', 'El curso fue creado exitosamente!');

		return redirect()->action('Administrador\CursoController@getIndex');
	}



	public function get_edit(Request $request)
	{
		
		$cursoEditable = Curso::findOrFail($request->get('id'));

		$id = $request->get('id');

		$asignaturas = Asignatura::paginate()->lists('nombre','id');

		$docentes = Docente::paginate()->lists('apellidos','id');

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/cursos/edit', compact('cursoEditable','id','asignaturas','docentes','var'));
	
	}



	public function put_update(Requests \EditCursoRequest $request)
	{
	
	
		$curso = Curso::findOrFail($request->get('id'));

		$curso->fill([
			'asignatura_id' => $request->get('asignatura'),
			'docente_id' => $request->get('docente'),
			'semestre' => $request->get('semestre'),
			'anio' => $request->get('anio'),
			'seccion' => $request->get('seccion')
			]);
		
		$curso->save();

		Session::flash('message','El curso fue editado exitosamente');
		
		return redirect()->action('Administrador\CursoController@getIndex');
	}

	public function delete_destroy(Request $request)
	{

		$curso = Curso::findOrFail($request->get('id'));

		$curso->delete();


		Session::flash('message','El curso fue eliminado');

		return redirect()->action('Administrador\CursoController@getIndex');
		
	}

	public function get_search(Request $request)
	{
		


			if(is_numeric((integer) $request->get('name')))
			{
				
				$name = array('name' => (integer) $request->get('name'));
				
				$rules = array('name' => 'max:8');


				$v =  \Validator::make($name,$rules);

				if($v->fails())
				 {

				 	Session::flash('message', 'No se encontraron resultados.');
					return redirect()->back();
				 }

			}
		
		
			if(trim($request->get('name')) != "")
			{

			 $datos_cursos = Curso::join('docentes','cursos.docente_id','=','docentes.id')
			 ->join('asignaturas','cursos.asignatura_id','=','asignaturas.id')
			 ->where('docentes.rut','=', (integer) $request->get('name'))
			 ->orWhere('docentes.nombres', 'like' , '%'.$request->get('name').'%')
			 ->orWhere('docentes.apellidos', 'like' , '%'.$request->get('name').'%')
			 ->orWhere('asignaturas.nombre','like','%'.$request->get('name').'%')
			 ->select('cursos.*','asignaturas.nombre','docentes.nombres','docentes.apellidos','docentes.rut')
			 ->paginate();

			$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

			
				if(!$datos_cursos->isEmpty())
				{
					return view('Administrador/cursos/list',compact('datos_cursos','var'));
				}

					Session::flash('message', 'No se encontraron resultados.');
					return redirect()->back();
				
			}


		 	return redirect()->action('Administrador\CursoController@getIndex');

	}


	public function get_upload(Request $request)
	{

		$asignaturas = Asignatura::where('departamento_id', '=', $request->get('departamento'))->paginate();

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/cursos/upload',compact('asignaturas','var'));
	}


	public function post_upload(Request $request)
	{

		 if(is_null($request->file('file')))
	     {
	     	Session::flash('message', 'Debes seleccionar un archivo.');

			return redirect()->back();
		 }
		 	     
		   $file = $request->file('file');
	    
	       $nombre = $file->getClientOriginalName();

	       \Storage::disk('local')->put($nombre,  \File::get($file));


			\Excel::load('/storage/app/'.$nombre,function($archivo)
			{
				$result = $archivo->get();


				foreach($result as $key => $value)
				{


					$asignatura_id = Asignatura::where('id','=',$value->asignatura)->pluck('id');

					if(is_null($asignatura_id))
					{
						continue;
					}

					$docente_id = Docente::where('id','=',$value->docente)->pluck('id');

					if(is_null($docente_id))
					{
						continue;
					}

					$tupla = Curso::where('asignatura_id','=',$value->asignatura)
									->where('docente_id','=',$value->docente)
									->where('semestre','=',$value->semestre)
									->where('anio','=',$value->anio)
									->where('seccion','=',$value->seccion)
									->first();

					if(is_null($tupla))
					{
						$var = new Curso();

						$var->fill([
							'asignatura_id' => $value->asignatura,
							'docente_id' => $value->docente,
							'semestre' => $value->semestre,
							'anio' => $value->anio,
							'seccion' => $value->seccion
							]);

						$var->save();
					}

				}
						
	
	       				

			})->get();

			\Storage::delete($nombre);
		
		    return redirect()->action('Administrador\CursoController@getIndex');
	
	}



	public function get_download()
	{
		$var = Curso::all();

		\Excel::create('Cursos',function($excel) use ($var)
		{
			$excel->sheet('Sheetname',function($sheet) use ($var)
			{
				$data=[];

				array_push($data, array('ASIGNATURA','DOCENTE','SEMESTRE','ANIO','SECCION'));

				foreach($var as $key => $v)
				{
					
					array_push($data, array($v->asignatura_id,$v->docente_id,$v->semestre,$v->anio,$v->seccion));

				}		
				$sheet->fromArray($data,null, 'A1', false,false);
			
			});
			
		})->download('xlsx');

			

	       return redirect()->action('Administrador\CursoController@getIndex');
	}



}
