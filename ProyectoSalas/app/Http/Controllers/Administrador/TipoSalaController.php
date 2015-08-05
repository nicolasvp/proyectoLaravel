<?php namespace App\Http\Controllers\Administrador;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use App\Models\Tipo_sala;
use App\Models\Rol_usuario;





class TipoSalaController extends Controller {


	protected $layout='layouts.master';

	public function getIndex()
	{

		$datos_tipos = Tipo_sala::paginate();

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/tipos_sala/list',compact('datos_tipos','var'));
	}

	public function get_create()
	{

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 
		
		return view('Administrador/tipos_sala/create',compact('var'));
	}


	public function post_store(Requests \CreateTipoSalaRequest $request)
	{
		
		$tipo= new Tipo_sala();
		$tipo->fill($request->all());
		$tipo->save();

		Session::flash('message', 'El tipo de sala '.$tipo->nombre.' fue creado exitosamente!');

		return redirect()->action('Administrador\TipoSalaController@getIndex');
	
	}



	public function get_edit(Request $request)
	{
		
		$tipoEditable = Tipo_sala::findOrFail($request->get('id'));

		$id = $request->get('id');

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/tipos_sala/edit', compact('tipoEditable','id','var'));
	
	}



	public function put_update(Request $request)
	{

		$tipo = Tipo_sala::findOrFail($request->get('id'));
		$tipo->fill(\Request::all());
		$tipo->save();
		
		Session::flash('message', 'El tipo de sala '.$tipo->nombre.' fue editado exitosamente!');

		return redirect()->action('Administrador\TipoSalaController@getIndex');
	}


	public function delete_destroy(Request $request)
	{

		$tipo = Tipo_sala::findOrFail($request->get('id'));

		$tipo->delete();


		Session::flash('message', 'El tipo de sala '.$tipo->nombre.' fue eliminado exitosamente!');;

		return redirect()->action('Administrador\TipoSalaController@getIndex');
		
	}

	public function get_upload()
	{

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/tipos_sala/upload',compact('var'));
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
						$var = new Tipo_sala();
						$var->fill(['nombre' => $value->nombre,'descripcion' => $value->descripcion]);
						$var->save();

					}

				})->get();
				Session::flash('message', 'Los tipos de salas fueron agregados exitosamente!');

		       return redirect()->action('Administrador\TipoSalaController@getIndex');
	}

	public function get_search(Request $request)
	{
		
			if(trim($request->get('name')) != "")
			{

			 $datos_tipos = Tipo_sala::where('tipos_salas.nombre', 'like' , '%'.$request->get('name').'%')
			->select('tipos_salas.*')
			->paginate();

			$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

			
				if(!$datos_tipos->isEmpty())
				{
					return view('Administrador/tipos_sala/list',compact('datos_tipos','var'));
				}

				else
				{
					Session::flash('message', 'No se encontraron resultados.');
					return redirect()->back();
				}
			}

			else
			{

		 	return redirect()->action('Administrador\TipoSalaController@getIndex');

			}
	}
	

}
