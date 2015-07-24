<?php namespace App\Http\Controllers\Administrador;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Estudiante;
use App\Models\Carrera;
use App\Models\Rol_usuario;





class EstudianteController extends Controller {


	protected $layout='layouts.master';
	

	public function getIndex()
	{
		$datos_estudiantes = Estudiante::join('carreras','estudiantes.carrera_id','=','carreras.id')
									->select('estudiantes.*','carreras.codigo as carrera')
									->paginate();

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/estudiantes/list',compact('datos_estudiantes','var'));
	}



		public function get_create()
	{

		$carreras = Carrera::paginate()->lists('nombre','id');

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/estudiantes/create',compact('carreras','var'));
	}


	public function post_store(Requests\CreateEstudianteRequest $request)
	{
		
		$estudiante = new Estudiante();
		$estudiante->fill(['carrera_id' => $request->get('carrera'), 'rut' => $request->get('rut'), 'nombres' => $request->get('nombres'),
			'apellidos' => $request->get('apellidos'), 'email' => $request->get('email')]);
		$estudiante->save();

		Session::flash('message', 'El estudiante '.$estudiante->nombres.' '.$estudiante->apellidos.' fue ingresado exitosamente!');
		return redirect()->action('Administrador\EstudianteController@getIndex');
	
	}





		public function get_edit(Request $request)
	{
		
		$estudianteEditable = Estudiante::findOrFail($request->get('id'));

		$carreras = Carrera::paginate()->lists('nombre','id');

		$id = $request->get('id');

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/estudiantes/edit', compact('estudianteEditable','id','carreras','var'));
	
	}



	public function put_update(Requests \EditEstudianteRequest $request)
	{

		$estudiante = Estudiante::findOrFail($request->get('id'));
		$estudiante->fill(\Request::all());
		$estudiante->save();
		
		Session::flash('message', 'El estudiante '.$estudiante->nombres.' '.$estudiante->apellidos.' fue editado exitosamente!');

		return redirect()->action('Administrador\EstudianteController@getIndex');
	}


	public function delete_destroy(Request $request)
	{

		$estudiante = Estudiante::findOrFail($request->get('id'));

		$estudiante->delete();


		Session::flash('message', 'El estudiante '.$estudiante->nombres.' '.$estudiante->apellidos.' fue eliminado exitosamente!');

		return redirect()->action('Administrador\EstudianteController@getIndex');
		
	}

		public function get_search(Request $request)
		{
		
			if(trim($request->get('name')) != "")
			{

			 $datos_estudiantes = Estudiante::join('carreras','estudiantes.carrera_id','=','carreras.id')
			->where('estudiantes.rut', '=' , $request->get('name'))
			->orWhere('carreras.codigo','=', $request->get('name'))
			->select('estudiantes.*','carreras.codigo as carrera')
			->paginate();

			$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

			return view('Administrador/estudiantes/list',compact('datos_estudiantes','var'));
			}

			else
			{

		 	return redirect()->action('Administrador\EstudianteController@getIndex');

			}
		}


		public function get_carrera()
	{
		$carreras = Carrera::all()->lists('nombre','id');

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/estudiantes/upload',compact('carreras','var'));
	}

	public function post_upload(Request $request)
	{

	    
		   $file = $request->file('file');
	    
	       $nombre = $file->getClientOriginalName();

	       \Storage::disk('local')->put($nombre,  \File::get($file));

			$carrera = $request->get('carrera');

			\Excel::load('/storage/app/'.$nombre,function($archivo) use ($carrera)
			{

				$result = $archivo->get();

				foreach($result as $key => $value)
				{
					$var = new Estudiante();
					$var->fill(['carrera_id' => $carrera,'rut' => $value->rut,'nombres' =>$value->nombres,'apellidos' => $value->apellidos,'email' =>$value->email]);
					$var->save();

				}

			})->get();
			Session::flash('message', 'Los alumnos fueron agregados exitosamente!');

	       return redirect()->action('Administrador\EstudianteController@getIndex');
	}	


}
