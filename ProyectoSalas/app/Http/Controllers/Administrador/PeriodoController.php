<?php namespace App\Http\Controllers\Administrador;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Periodo;




class PeriodoController extends Controller {


	protected $layout='layouts.master';
	
	public function getIndex()
	{

		$datos_periodos = Periodo::paginate();
		return view('Administrador/periodos/list',compact('datos_periodos'));
	}

	public function get_create()
	{

		return view('Administrador/periodos/create');
	}


	public function post_store()
	{
		
		$periodo= new Periodo();
		$periodo->fill(\Request::all());
		$periodo->save();

		Session::flash('message', 'El periodo '.$periodo->bloque.' fue creado exitosamente!');

		return redirect()->action('Administrador\PeriodoController@getIndex');
	
	}



	public function get_edit(Request $request)
	{
		
		$periodoEditable = Periodo::findOrFail($request->get('id'));


		$id = $request->get('id');

		return view('Administrador/periodos/edit', compact('periodoEditable','id'));
	
	}



	public function put_update(Request $request)
	{

		$periodo = Periodo::findOrFail($request->get('id'));
		$periodo->fill(\Request::all());
		$periodo->save();
		
		Session::flash('message', 'El periodo '.$periodo->bloque.' fue editado exitosamente!');

		return redirect()->action('Administrador\PeriodoController@getIndex');
	}


	public function delete_destroy(Request $request)
	{

		$periodo = Periodo::findOrFail($request->get('id'));

		$periodo->delete();


		Session::flash('message', 'El periodo '.$periodo->bloque.' fue eliminado exitosamente!');

		return redirect()->action('Administrador\PeriodoController@getIndex');
		
	}

	public function get_upload()
	{
		return view('Administrador/periodos/upload');
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
						$var = new Periodo();
						$var->fill(['bloque' => $value->bloque,'inicio' => $value->inicio,'fin' => $value->fin]);
						$var->save();

					}

				})->get();
				Session::flash('message', 'Los períodos fueron agregados exitosamente!');

		       return redirect()->action('Administrador\PeriodoController@getIndex');
	}

}
