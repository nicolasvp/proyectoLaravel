<?php namespace App\Http\Controllers\Administrador;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use Request;
use Illuminate\Support\Facades\Session;

use App\Models\Tipo_sala;





class TipoSalaController extends Controller {


	protected $layout='layouts.master';

	public function getIndex()
	{

		$datos_tipos = Tipo_sala::paginate();
		return view('Administrador/tipos_sala/list',compact('datos_tipos'));
	}

	public function get_create()
	{
		
		return view('Administrador/tipos_sala/create');
	}


	public function post_store()
	{
		
		$tipo= new Tipo_sala();
		$tipo->fill(\Request::all());
		$tipo->save();

		Session::flash('message', 'El tipo de sala '.$tipo->nombre.' fue creado exitosamente!');

		return redirect()->action('Administrador\TipoSalaController@getIndex');
	
	}



	public function get_edit(Request $request)
	{
		
		$tipoEditable = Tipo_sala::findOrFail($request->get('id'));

		$id = $request->get('id');

		return view('Administrador/tipos_sala/edit', compact('tipoEditable','id'));
	
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
		return view('Administrador/tipos_sala/upload');
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

			return view('Administrador/tipos_sala/list',compact('datos_tipos'));
			}

			else
			{

		 	return redirect()->action('Administrador\TipoSalaController@getIndex');

			}
	}
	

}
