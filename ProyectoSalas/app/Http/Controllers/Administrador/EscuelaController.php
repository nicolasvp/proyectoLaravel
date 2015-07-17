<?php namespace App\Http\Controllers\Administrador;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use Request;
use Illuminate\Support\Facades\Session;
use App\Models\Departamento;
use App\Models\Escuela;




class EscuelaController extends Controller {


	protected $layout='layouts.master';
	
	public function getIndex()
	{

		$datos_escuelas = Escuela::join('departamentos','escuelas.departamento_id','=','departamentos.id')
						->select('escuelas.*','departamentos.nombre as departamento')
						->paginate();

	
		return view('Administrador/escuelas/list',compact('datos_escuelas'));

	}


	public function get_create()
	{

		$departamentos = Departamento::paginate()->lists('nombre','id');

		return view('Administrador/escuelas/create',compact('departamentos'));
	}


	public function post_store()
	{
		
		$escuela= new Escuela();
		$escuela->fill(\Request::all());
		$escuela->save();

		Session::flash('message', 'La escuela '.$escuela->nombre.' fue creada exitosamente!');

		return redirect()->action('Administrador\EscuelaController@getIndex');
	
	}



	public function get_edit(Request $request)
	{
		
		$escuelaEditable = Escuela::findOrFail($request->get('id'));

		$departamentos = Departamento::paginate()->lists('nombre','id');

		$id = $request->get('id');

		return view('Administrador/escuelas/edit', compact('escuelaEditable','id','departamentos'));
	
	}



	public function put_update(Request $request)
	{

		$escuela = Escuela::findOrFail($request->get('id'));
		$escuela->fill(\Request::all());
		$escuela->save();
		
		Session::flash('message', 'La escuela '.$escuela->nombre.' fue editada exitosamente!');

		return redirect()->action('Administrador\EscuelaController@getIndex');
	}


	public function delete_destroy(Request $request)
	{

		$escuela = Escuela::findOrFail($request->get('id'));

		$escuela->delete();


		Session::flash('message', 'La escuela '.$escuela->nombre.' fue eliminada exitosamente!');

		return redirect()->action('Administrador\EscuelaController@getIndex');
		
	}

	public function get_depto()
	{
		$departamentos = Departamento::all()->lists('nombre','id');

		return view('Administrador/escuelas/upload',compact('departamentos'));
	}


	public function post_upload(Request $request)
	{

	 
		   $file = $request->file('file');
	 
	       $nombre = $file->getClientOriginalName();

	       \Storage::disk('local')->put($nombre,  \File::get($file));

			$departamento = $request->get('departamento');

			\Excel::load('/storage/app/'.$nombre,function($archivo) use ($departamento)
			{

				$result = $archivo->get();

				foreach($result as $key => $value)
				{
					$var = new Escuela();
					$var->fill(['nombre' => $value->nombre,'departamento_id' => $departamento,'descripcion' =>$value->descripcion]);
					$var->save();

				}

			})->get();
			Session::flash('message', 'Las escuelas fueron agregadas exitosamente!');

	       return redirect()->action('Administrador\EscuelaController@getIndex');
	}

	public function get_search(Request $request)
		{
		
			if(trim($request->get('name')) != "")
			{

			 $datos_escuelas = Escuela::join('departamentos','escuelas.departamento_id','=','departamentos.id')
			->where('escuelas.nombre', 'like' ,'%'.$request->get('name').'%')
			->orWhere('departamentos.nombre','like', '%'.$request->get('name').'%')
			->select('escuelas.*','departamentos.nombre as departamento')
			->paginate();

			return view('Administrador/escuelas/list',compact('datos_escuelas'));
			}

			else
			{

		 	return redirect()->action('Administrador\EscuelaController@getIndex');

			}
		}


}
