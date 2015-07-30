<?php namespace App\Http\Controllers\Administrador;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use App\Models\Rol_usuario;
use App\Models\Usuario;



class UsuarioController extends Controller {


	protected $layout='layouts.master';
	
	public function getIndex()
	{
			
		$datos_usuarios = Usuario::paginate();

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/usuarios/list',compact('datos_usuarios','var'));
	}


	public function get_create()
	{


		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/usuarios/create',compact('var'));
	}


	public function post_store(Requests \CreateUsuarioRequest $request)
	{


			$rut = array(
				'rut' => \App\RutUtils::rut($request->get('rut'))
				);
			
			$rules = array(
				'rut' => 'unique:usuarios,rut'
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
		


		Session::flash('message', 'El usuario '.$var->nombres.' '.$var->apellidos.' fue creado exitosamente!');

		return redirect()->action('Administrador\UsuarioController@getIndex');
	}






	public function get_edit(Request $request)
	{
		
		$usuarioEditable = Usuario::findOrFail($request->get('rut'));

		$rut = \App\RutUtils::formatear($usuarioEditable->rut);


		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/usuarios/edit', compact('usuarioEditable','rut','var'));
	
	}



	public function put_update(Requests \EditUsuarioRequest $request)
	{
	
/*
		$rut = array(
			'rut' => \App\RutUtils::rut($request->get('rut'))
		);
			
		$rules = array(
				'rut' => 'unique:usuarios,rut,'.\App\RutUtils::rut($request->get('rut'))
				);
	
		$v =  \Validator::make($rut,$rules);

		if($v->fails())
		 {
			return redirect()->back()
					->withErrors($v->errors())
					->withInput(\Request::all());
		 }
*/

		$rut = \App\RutUtils::rut($request->get('rut'));

		$usuario = Usuario::findOrFail($rut);

		$usuario->fill([
				'rut' => $rut,
				'email' => $request->get('email'),
				'nombres' => $request->get('nombres'), 
				'apellidos' => $request->get('apellidos')
				]);

		$usuario->save();
		
		Session::flash('message', 'El usuario '.$usuario->nombres.' '.$usuario->apellidos.' fue editado exitosamente!');

		return redirect()->action('Administrador\UsuarioController@getIndex');
	}


	public function delete_destroy(Request $request)
	{

		$usuario = Usuario::findOrFail($request->get('rut'));

		$usuario->delete();


		Session::flash('message', 'El usuario '.$usuario->nombres.' '.$usuario->apellidos.' fue eliminado exitosamente!');

		return redirect()->action('Administrador\UsuarioController@getIndex');
		
	}

	public function get_search(Request $request)
	{
		
			if(trim($request->get('name')) != "")
			{

			 $datos_usuarios = Usuario::where('rut', '=' , (integer) $request->get('name'))
			->orWhere('nombres','like','%'.$request->get('name').'%')
			->orWhere('apellidos','like','%'.$request->get('name').'%')
			->orWhere('email','=',$request->get('name'))
			->paginate();

			$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

			return view('Administrador/usuarios/list',compact('datos_usuarios','var'));
			}

			else
			{

		 	return redirect()->action('Administrador\UsuarioController@getIndex');

			}
		

	}



	public function post_upload(Request $request)
	{

	    
		   $file = $request->file('file');
	  
	       $nombre = $file->getClientOriginalName();

	       \Storage::disk('local')->put($nombre,  \File::get($file));

			\Excel::load('/storage/app/'.$nombre,function($archivo) 
			{

				$result = $archivo->get();

				foreach($result as $key => $value)
				{

					$var = new Usuario();

					$var->fill([
						'rut' => $value->rut,
						'email' => $value->email,
						'nombres' => $value->nombres, 
						'apellidos' => $value->apellidos
						]);

					$var->save();


				}

			})->get();
			Session::flash('message', 'Los usuarios fueron agregados exitosamente!');

	       return redirect()->action('Administrador\UsuarioController@getIndex');
	}


}
