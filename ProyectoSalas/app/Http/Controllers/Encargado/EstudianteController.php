<?php namespace App\Http\Controllers\Encargado;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


use App\Models\Departamento;
use App\Models\Docente;
use App\Models\Estudiante;
use App\Models\Carrera;
use App\Models\Rol_usuario;
use App\Models\Usuario;


class EstudianteController extends Controller {

	

	public function getIndex()
	{
		$datos_estudiantes = Estudiante::join('carreras','estudiantes.carrera_id','=','carreras.id')
									->select('estudiantes.*','carreras.codigo as carrera')
									->paginate();

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre'); 

		return view('Encargado/estudiantes/list',compact('datos_estudiantes','var'));
	}


	public function get_create(Request $request)
	{
		
			$carreras = Carrera::paginate()->lists('nombre','id');

			$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre'); 

			return view('Encargado/estudiantes/create',compact('carreras','var'));
		
		
	}


	public function post_store(Requests\CreateEstudianteRequest $request)
	{
		
		$rut = array(
				'rut' => \App\RutUtils::rut($request->get('rut'))
				);
			
		$rules = array(
				'rut' => 'unique:estudiantes,rut'
				);
	
		$v =  \Validator::make($rut,$rules);


		if($v->fails())
		 {
			return redirect()->back()
					->withErrors($v->errors())
					->withInput(\Request::all());
		 }

		$rut = \App\RutUtils::rut($request->get('rut'));
		
		$usuario = new Usuario();

		$usuario->fill([
				'rut' => $rut,
				'email' => $request->get('email'),
				'nombres' => $request->get('nombres'), 
				'apellidos' => $request->get('apellidos')
				]);

		$usuario->save();


		$rol_usuario = new Rol_usuario();

		$rol_usuario->fill([
				'rol_id' => '3',
				'rut' => $rut
				]);

		$rol_usuario->save();

		$estudiante = new Estudiante();

		$estudiante->fill([
			'carrera_id' => $request->get('carrera'), 
			'rut' => $rut, 
			'nombres' => $request->get('nombres'),
			'apellidos' => $request->get('apellidos'), 
			'email' => $request->get('email')
			]);

		$estudiante->save();

		Session::flash('message', 'El estudiante '.$estudiante->nombre.'  '.$estudiante->apellidos.' fue creado exitosamente!');
		return redirect()->action('Encargado\EstudianteController@getIndex');
	
	}




	public function get_edit(Request $request)
	{
		
		$estudianteEditable = Estudiante::findOrFail($request->get('id'));

		$rut = \App\RutUtils::formatear($estudianteEditable->rut);

		$carreras = Carrera::paginate()->lists('nombre','id');

		$id = $request->get('id');

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre'); 

		return view('Encargado/estudiantes/edit', compact('estudianteEditable','rut','id','carreras','var'));
	
	}



	public function put_update(Requests \EditEstudianteRequest $request)
	{

		$estudiante = Estudiante::findOrFail($request->get('id'));


		$rut = array(
				'rut' => \App\RutUtils::rut($request->get('rut'))
				);
			
		$rules = array(
				'rut' => 'unique:estudiantes,rut,'.$request->get('id')
				);
	
		$v =  \Validator::make($rut,$rules);


		if($v->fails())
		 {
			return redirect()->back()
					->withErrors($v->errors())
					->withInput(\Request::all());
		 }

		$rut = \App\RutUtils::rut($request->get('rut'));

		$usuario = Usuario::findOrFail($estudiante->rut);

		$usuario->fill([
				'rut' => $rut,
				'email' => $request->get('email'),
				'nombres' => $request->get('nombres'), 
				'apellidos' => $request->get('apellidos')
				]);

		$usuario->save();

		$estudiante->fill([
			'carrera_id' => $request->get('carrera'), 
			'rut' => $rut,
			'nombres' => $request->get('nombres'),
			'apellidos' => $request->get('apellidos'),
			'email' => $request->get('email')
						]);

		$estudiante->save();
		
		Session::flash('message', 'El estudiante '.$estudiante->nombres.' '.$estudiante->apellidos.' fue editado exitosamente!');

		return redirect()->action('Encargado\EstudianteController@getIndex');
	}



	public function delete_destroy(Request $request)
	{

		$estudiante = Usuario::findOrFail($request->get('rut'));

		$estudiante->delete();


		Session::flash('message', 'El estudiante '.$estudiante->nombres.' '.$estudiante->apellidos.' fue eliminado exitosamente!');

		return redirect()->action('Encargado\EstudianteController@getIndex');
		
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

			return view('Encargado/estudiantes/list',compact('datos_estudiantes','var'));
			}

			else
			{

		 	return redirect()->action('Encargado\EstudianteController@getIndex');

			}
		}


	public function get_carreras()
	{
		$carreras = Carrera::all()->lists('nombre','id');

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre'); 

		return view('Encargado/estudiantes/upload',compact('carreras','var'));
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
					$estudiantes = new Estudiante();
					$estudiantes->fill(['carrera_id' => $carrera,'rut' => $value->rut,'nombres' =>$value->nombres,'apellidos' => $value->apellidos,'email' =>$value->email]);
					$estudiantes->save();

				}

			})->get();
			Session::flash('message', 'Los alumnos fueron agregados exitosamente!');

	       return redirect()->action('Encargado\EstudianteController@getIndex');
	}

}
