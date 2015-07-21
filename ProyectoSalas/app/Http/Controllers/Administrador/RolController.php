<?php namespace App\Http\Controllers\Administrador;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Rol;




class RolController extends Controller {


	protected $layout='layouts.master';
	
	public function getIndex()
	{

		$datos_roles = Rol::paginate();
		return view('Administrador/roles/list',compact('datos_roles'));
	}

	public function get_create()
	{

		return view('Administrador/roles/create');
	}


	public function post_store(Requests \CreateRolRequest $request)
	{
		
		$rol= new Rol();
		$rol->fill($request->all());
		$rol->save();

		Session::flash('message', 'El rol '.$rol->nombre.' fue creado exitosamente!');

		return redirect()->action('Administrador\RolController@getIndex');
	
	}



	public function get_edit(Request $request)
	{
		
		$rolEditable = Rol::findOrFail($request->get('id'));


		$id = $request->get('id');

		return view('Administrador/roles/edit', compact('rolEditable','id'));
	
	}



	public function put_update(Requests \EditRolRequest $request)
	{

		$rol = Rol::findOrFail($request->get('id'));
		$rol->fill(\Request::all());
		$rol->save();
		
		Session::flash('message', 'El rol '.$rol->nombre.' fue editado exitosamente!');

		return redirect()->action('Administrador\RolController@getIndex');
	}


	public function delete_destroy(Request $request)
	{

		$rol = Rol::findOrFail($request->get('id'));

		$rol->delete();


		Session::flash('message', 'El rol '.$rol->nombre.' fue eliminado exitosamente!');

		return redirect()->action('Administrador\RolController@getIndex');
		
	}

	public function get_upload()
	{
		return view('Administrador/roles/upload');
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
						$var = new Rol();
						$var->fill(['nombre' => $value->nombre,'descripcion' => $value->descripcion]);
						$var->save();

					}

				})->get();
				Session::flash('message', 'Los roles fueron agregados exitosamente!');

		       return redirect()->action('Administrador\RolController@getIndex');
	}

		public function get_search(Request $request)
		{
		
			if(trim($request->get('name')) != "")
			{

			 $datos_roles = Rol::where('roles.nombre', 'like' , '%'.$request->get('name').'%')
			->select('roles.*')
			->paginate();

			return view('Administrador/roles/list',compact('datos_roles'));
			}

			else
			{

		 	return redirect()->action('Administrador\RolController@getIndex');

			}
		}

}
