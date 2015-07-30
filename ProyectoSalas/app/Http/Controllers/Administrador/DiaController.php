<?php namespace App\Http\Controllers\Administrador;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use Request;
use Illuminate\Support\Facades\Session;
use App\Models\Dia;




class DiaController extends Controller {


	protected $layout='layouts.master';
	
	public function getIndex()
	{

		$datos_dias = Dia::paginate();
		return view('Administrador/dias/list',compact('datos_dias'));
	}

	public function get_create()
	{

		return view('Administrador/dias/create');
	}


	public function post_store()
	{
		
		$dia= new Dia();
		$dia->fill(\Request::all());
		$dia->save();

		Session::flash('message', 'El dia '.$dia->nombre.' fue creado exitosamente!');

		return redirect()->action('Administrador\DiaController@getIndex');
	
	}



	public function get_edit(Request $request)
	{
		
		$diaEditable = Dia::findOrFail($request->get('id'));


		$id = $request->get('id');

		return view('Administrador/dias/edit', compact('diaEditable','id'));
	
	}



	public function put_update(Request $request)
	{

		$dia = Dia::findOrFail($request->get('id'));
		$dia->fill(\Request::all());
		$dia->save();
		
		Session::flash('message', 'El dia '.$dia->nombre.' fue editado exitosamente!');

		return redirect()->action('Administrador\DiaController@getIndex');
	}


	public function delete_destroy(Request $request)
	{

		$dia = Dia::findOrFail($request->get('id'));

		$dia->delete();


		Session::flash('message', 'El dia '.$dia->nombre.' fue eliminado exitosamente!');

		return redirect()->action('Administrador\DiaController@getIndex');
		
	}

	public function get_upload()
	{
		return view('Administrador/dias/upload');
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
						$var = new Dia();
						$var->fill(['nombre' => $value->nombre]);
						$var->save();

					}

				})->get();
				Session::flash('message', 'Los dias fueron agregados exitosamente!');

		       return redirect()->action('Administrador\DiaController@getIndex');
	}
}
