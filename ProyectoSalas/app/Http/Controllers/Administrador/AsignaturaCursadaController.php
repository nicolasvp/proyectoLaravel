<?php namespace App\Http\Controllers\Administrador;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use Request;
use Illuminate\Support\Facades\Session;

use App\Models\Asignatura;
use App\Models\Departamento;
use App\Models\Rol_usuario;
use App\Models\Curso;
use App\Models\Estudiante;
use App\Models\Asignatura_cursada;




class AsignaturaCursadaController extends Controller {


	protected $layout='layouts.master';

	public function getIndex()
	{
		$datos_cursos = Curso::join('asignaturas', 'cursos.asignatura_id', '=','asignaturas.id')
							->join('docentes','cursos.docente_id','=','docentes.id')
							->select('cursos.*','asignaturas.nombre','docentes.nombres','docentes.apellidos','docentes.rut')
							->paginate();
			
		$k = Asignatura_cursada::join('cursos','asignaturas_cursadas.curso_id','=','cursos.id')
								->count('asignaturas_cursadas.curso_id');

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/asignar_estudiantes/list',compact('datos_cursos','var'));
	}


	public function get_create(Request $request)
	{

		$curso_id = $request->get('id'); 

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre');  

		return view('Administrador/asignar_estudiantes/create',compact('var','curso_id'));
	}


	public function post_store(Request $request)
	{
	
			if(!is_numeric($request->get('rut')))
			{
					Session::flash('message', 'Debe ingresar solo números.');
					return redirect()->back();
			}
			
			$name = array('name' => (integer) $request->get('rut'));
			
			$rules = array('name' => 'max:8');


			$v =  \Validator::make($name,$rules);

			if($v->fails())
			 {
			 	Session::flash('message', 'No se encontraron resultados.');
				return redirect()->back();
			 }


		if(trim($request->get('rut')) != "")
		{
		
			$estudiante_id = Estudiante::where('rut','=',$request->get('rut'))->pluck('id');

			$datos_usuario = Asignatura_cursada::where('estudiante_id','=',$estudiante_id)->where('curso_id','=',$request->get('id'))->first();

			if(is_null($datos_usuario))
			{

					$asignatura = new Asignatura_cursada();

					$asignatura->fill([
						'curso_id' => $request->get('id'),
						'estudiante_id' => $estudiante_id
						]);

					$asignatura->save();


					Session::flash('message', 'El estudiante fue asignado al curso exitosamente!');

					return redirect()->action('Administrador\AsignaturaCursadaController@getIndex');
			}

			Session::flash('message', 'No existe ningún usuario con ese rut.');

			return redirect()->back();

		}

		else
		{

		 return redirect()->back();

		}



	
	}


	public function get_upload(Request $request)
	{

		$curso_id = $request->get('id');

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/asignar_estudiantes/upload',compact('var','curso_id'));
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

			$curso_id = $request->get('id');



			\Excel::load('/storage/app/'.$nombre,function($archivo) use ($curso_id) 
			{
				
				$result = $archivo->get();

				foreach($result as $key => $value)
				{
					$var = new Asignatura_cursada();

					$estudiante_id = Estudiante::where('rut','=',$value->rut)->pluck('id');

					if(is_null($estudiante_id))
					{
		
						continue;
					}
				
					$tupla = Asignatura_cursada::where('curso_id','=',$curso_id)->where('estudiante_id','=',$estudiante_id)->pluck('id');
						
					if(!is_null($tupla))
					{
						continue;

					}

						$var->fill([
							'curso_id' => $curso_id,
							'estudiante_id' => $estudiante_id
							]);	

						$var->save();
					
				}
	       

			})->get();

			\Storage::delete($nombre);
			
			Session::flash('message', 'Los estudiantes fueron ingresados exitosamente!');

	       return redirect()->action('Administrador\AsignaturaCursadaController@getIndex');



	}



	public function get_download()
	{
		$var = Asignatura::all();

		\Excel::create('Asignaturas',function($excel) use ($var)
		{
			$excel->sheet('Sheetname',function($sheet) use ($var)
			{
				$data=[];

				array_push($data, array('CODIGO','NOMBRE','DESCRIPCION'));

				foreach($var as $key => $v)
				{
					
					array_push($data, array($v->codigo,$v->nombre,$v->descripcion));

				}		
				$sheet->fromArray($data,null, 'A1', false,false);
			
			});
			
		})->download('xlsx');

			

	       return redirect()->action('Administrador\CampusController@get_list');
	}
	


}
