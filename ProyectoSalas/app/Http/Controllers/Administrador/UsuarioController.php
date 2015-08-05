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
		

			if(is_numeric( (integer) $request->get('name')))
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

			 $datos_usuarios = Usuario::where('rut', '=' , (integer) $request->get('name'))
			->orWhere('nombres','like','%'.$request->get('name').'%')
			->orWhere('apellidos','like','%'.$request->get('name').'%')
			->orWhere('email','=',$request->get('name'))
			->paginate();

			$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

		
				if(!$datos_usuarios->isEmpty())
				{
					return view('Administrador/usuarios/list',compact('datos_usuarios','var'));
				}

				else
				{
					Session::flash('message', 'No se encontraron resultados.');
					return redirect()->back();
				}

			}

			else
			{

		 	return redirect()->action('Administrador\UsuarioController@getIndex');

			}
		

	}

	public function get_upload()
	{
		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/usuarios/upload',compact('var'));
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

					$rut_valido = \App\RutUtils::isRut($value->rut);

					if(!$rut_valido)
					{
						continue;
					}

					$rut = \App\RutUtils::rut($value->rut);

					$usuario = Usuario::where('rut','=',$rut)->first();

					if(!is_null($usuario))
					{
						continue;
					}

					$email = Usuario::where('email','=',$value->email)->first();

					if(is_null($email))
					{
						$var = new Usuario();

						$var->fill([
								'rut' => $rut,
								'email' => $value->email,
								'nombres' => $value->nombres, 
								'apellidos' => $value->apellidos
								]);

						$var->save();
					}
					

				}

			})->get();
			

	       return redirect()->action('Administrador\UsuarioController@getIndex');
	}



	public function get_download()
	{
		$var = Usuario::all();

		\Excel::create('Usuarios',function($excel) use ($var)
		{
			$excel->sheet('Sheetname',function($sheet) use ($var)
			{
				$data=[];

				array_push($data, array('RUT','EMAIL','NOMBRES','APELLIDOS'));

				foreach($var as $key => $v)
				{
					$a = \App\RutUtils::dv($v->rut);
					$rut = $v->rut."-".$a;
					
					array_push($data, array($rut,$v->email,$v->nombres,$v->apellidos));

				}		
				$sheet->fromArray($data,null, 'A1', false,false);
			
			});
			
		})->download('xlsx');

			

	       return redirect()->action('Administrador\UsuarioController@getIndex');
	}


}
