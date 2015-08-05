<?php namespace App\Http\Controllers\Administrador;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Rol;
use App\Models\Rol_usuario;




class RolController extends Controller {


	protected $layout='layouts.master';
	
	public function getIndex()
	{

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre');

		return view('Administrador/roles/index',compact('var'));

	}

	public function get_roles()
	{

		$datos_roles = Rol::paginate();

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre');

		return view('Administrador/roles/list',compact('datos_roles','var'));
	}

	public function get_create()
	{

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre');

		return view('Administrador/roles/create',compact('var'));
	}


	public function post_store(Requests \CreateRolRequest $request)
	{
		
		$rol= new Rol();
		$rol->fill($request->all());
		$rol->save();

		Session::flash('message', 'El rol '.$rol->nombre.' fue creado exitosamente!');

		return redirect()->action('Administrador\RolController@get_roles');
	
	}



	public function get_edit(Request $request)
	{
		
		$rolEditable = Rol::findOrFail($request->get('id'));


		$id = $request->get('id');

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre');

		return view('Administrador/roles/edit', compact('rolEditable','id','var'));
	
	}



	public function put_update(Requests \EditRolRequest $request)
	{

		$rol = Rol::findOrFail($request->get('id'));
		$rol->fill(\Request::all());
		$rol->save();
		
		Session::flash('message', 'El rol '.$rol->nombre.' fue editado exitosamente!');

		return redirect()->action('Administrador\RolController@get_roles');
	}


	public function delete_destroy(Request $request)
	{

		$rol = Rol::findOrFail($request->get('id'));

		$rol->delete();


		Session::flash('message', 'El rol '.$rol->nombre.' fue eliminado exitosamente!');

		return redirect()->action('Administrador\RolController@get_roles');
		
	}

		public function get_search(Request $request)
		{
		
			if(trim($request->get('name')) != "")
			{

			 $datos_roles = Rol::where('roles.nombre', 'like' , '%'.$request->get('name').'%')
						->select('roles.*')
						->paginate();

			$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre');

			
				if(!$datos_roles->isEmpty())
				{
					return view('Administrador/roles/list',compact('datos_roles','var'));
				}

				else
				{
					Session::flash('message', 'No se encontraron resultados.');
					return redirect()->back();
				}
			}

			else
			{

		 	return redirect()->action('Administrador\RolController@get_roles');

			}
		}


	public function get_upload()
	{

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre');

		return view('Administrador/roles/upload',compact('var'));
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
						$nombre = Rol::where('nombre','=',$value->nombre)->pluck('id');

						if(is_null($nombre))
						{
							$var = new Rol();
							$var->fill(['nombre' => $value->nombre,'descripcion' => $value->descripcion]);
							$var->save();
						}
					}

				})->get();
				

		       return redirect()->action('Administrador\RolController@get_roles');

	}




	public function get_download()
	{
		$var = Rol::all();

		\Excel::create('Roles',function($excel) use ($var)
		{
			$excel->sheet('Sheetname',function($sheet) use ($var)
			{
				$data=[];

				array_push($data, array('NOMBRE','DESCRIPCION'));

				foreach($var as $key => $v)
				{
					
					array_push($data, array($v->nombre,$v->descripcion));

				}		
				$sheet->fromArray($data,null, 'A1', false,false);
			
			});
			
		})->download('xlsx');

			

	       return redirect()->action('Administrador\RolController@get_roles');
	}


}
