<?php namespace App\Http\Controllers\Administrador;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Estudiante;
use App\Models\Carrera;
use App\Models\Rol_usuario;
<<<<<<< HEAD
use App\Models\User;
use App\Models\Usuario;	

=======
>>>>>>> d54c8fa948ab220500fe59fd7e40157631c5a416





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



<<<<<<< HEAD
	public function get_create()
=======
		public function get_create()
>>>>>>> d54c8fa948ab220500fe59fd7e40157631c5a416
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
		
<<<<<<< HEAD
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
		
		$var = new Usuario();

		$var->fill([
				'rut' => $rut,
				'email' => $request->get('email'),
				'nombres' => $request->get('nombres'), 
				'apellidos' => $request->get('apellidos')
				]);

		$var->save();
					

		$var2 = new Rol_usuario();

		$var2->fill([
				'rol_id' => '3',
				'rut' => $rut
				]);

		$var2->save();

		$var3 = new Estudiante();

		$var3->fill([
			'carrera_id' => $request->get('carrera'), 
			'rut' => $rut,
			'nombres' => $request->get('nombres'),
			'apellidos' => $request->get('apellidos'),
			'email' => $request->get('email')
				]);

		$var3->save();		

		Session::flash('message', 'El estudiante '.$var3->nombres.' '.$var3->apellidos.' fue ingresado exitosamente!');
		
=======
		$estudiante = new Estudiante();
		$estudiante->fill(['carrera_id' => $request->get('carrera'), 'rut' => $request->get('rut'), 'nombres' => $request->get('nombres'),
			'apellidos' => $request->get('apellidos'), 'email' => $request->get('email')]);
		$estudiante->save();

		Session::flash('message', 'El estudiante '.$estudiante->nombres.' '.$estudiante->apellidos.' fue ingresado exitosamente!');
>>>>>>> d54c8fa948ab220500fe59fd7e40157631c5a416
		return redirect()->action('Administrador\EstudianteController@getIndex');
	
	}





<<<<<<< HEAD
	public function get_edit(Request $request)
=======
		public function get_edit(Request $request)
>>>>>>> d54c8fa948ab220500fe59fd7e40157631c5a416
	{
		
		$estudianteEditable = Estudiante::findOrFail($request->get('id'));

<<<<<<< HEAD
		$rut = \App\RutUtils::formatear($estudianteEditable->rut);
	
		$carreras = Carrera::all()->lists('nombre','id');
=======
		$carreras = Carrera::paginate()->lists('nombre','id');
>>>>>>> d54c8fa948ab220500fe59fd7e40157631c5a416

		$id = $request->get('id');

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

<<<<<<< HEAD
		return view('Administrador/estudiantes/edit', compact('estudianteEditable','rut','id','carreras','var'));
=======
		return view('Administrador/estudiantes/edit', compact('estudianteEditable','id','carreras','var'));
>>>>>>> d54c8fa948ab220500fe59fd7e40157631c5a416
	
	}



	public function put_update(Requests \EditEstudianteRequest $request)
	{

		$estudiante = Estudiante::findOrFail($request->get('id'));
<<<<<<< HEAD


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

=======
		$estudiante->fill(\Request::all());
		$estudiante->save();
>>>>>>> d54c8fa948ab220500fe59fd7e40157631c5a416
		
		Session::flash('message', 'El estudiante '.$estudiante->nombres.' '.$estudiante->apellidos.' fue editado exitosamente!');

		return redirect()->action('Administrador\EstudianteController@getIndex');
	}


	public function delete_destroy(Request $request)
	{

<<<<<<< HEAD
		//elimina en cascada
		$estudiante = Usuario::findOrFail($request->get('rut'));

		$estudiante->delete();
		//$estudiante = Estudiante::findOrFail($request->get('id'));

		//$estudiante->delete();
=======
		$estudiante = Estudiante::findOrFail($request->get('id'));

		$estudiante->delete();
>>>>>>> d54c8fa948ab220500fe59fd7e40157631c5a416


		Session::flash('message', 'El estudiante '.$estudiante->nombres.' '.$estudiante->apellidos.' fue eliminado exitosamente!');

		return redirect()->action('Administrador\EstudianteController@getIndex');
		
	}

<<<<<<< HEAD
	public function get_search(Request $request)
	{
=======
		public function get_search(Request $request)
		{
>>>>>>> d54c8fa948ab220500fe59fd7e40157631c5a416
		
			if(trim($request->get('name')) != "")
			{

			 $datos_estudiantes = Estudiante::join('carreras','estudiantes.carrera_id','=','carreras.id')
<<<<<<< HEAD
			->where('estudiantes.rut', '=' , (integer) $request->get('name'))
			->orWhere('carreras.codigo','=', (integer) $request->get('name'))
=======
			->where('estudiantes.rut', '=' , $request->get('name'))
			->orWhere('carreras.codigo','=', $request->get('name'))
>>>>>>> d54c8fa948ab220500fe59fd7e40157631c5a416
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
<<<<<<< HEAD
	}


	public function get_carrera()
=======
		}


		public function get_carrera()
>>>>>>> d54c8fa948ab220500fe59fd7e40157631c5a416
	{
		$carreras = Carrera::all()->lists('nombre','id');

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/estudiantes/upload',compact('carreras','var'));
	}

<<<<<<< HEAD


=======
>>>>>>> d54c8fa948ab220500fe59fd7e40157631c5a416
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
<<<<<<< HEAD
					
					$var = new Usuario();

					$var->fill([
						'rut' => $value->rut,
						'email' => $value->email,
						'nombres' => $value->nombres, 
						'apellidos' => $value->apellidos
						]);

					$var->save();
					

					$var2 = new Rol_usuario();
					$var2->fill([
						'rol_id' => '3',
						'rut' => $value->rut
						]);

					$var2->save();

					$var3 = new Estudiante();
					$var3->fill([
						'carrera_id' => $carrera,
						'rut' => $value->rut,
						'nombres' =>$value->nombres,
						'apellidos' => $value->apellidos,
						'email' =>$value->email
						]);

					$var3->save();
=======
					$var = new Estudiante();
					$var->fill(['carrera_id' => $carrera,'rut' => $value->rut,'nombres' =>$value->nombres,'apellidos' => $value->apellidos,'email' =>$value->email]);
					$var->save();
>>>>>>> d54c8fa948ab220500fe59fd7e40157631c5a416

				}

			})->get();
			Session::flash('message', 'Los alumnos fueron agregados exitosamente!');

	       return redirect()->action('Administrador\EstudianteController@getIndex');
	}	


}
