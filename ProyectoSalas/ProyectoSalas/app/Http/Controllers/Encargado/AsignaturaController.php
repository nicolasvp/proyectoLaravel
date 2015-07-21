<?php namespace App\Http\Controllers\Encargado;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


use App\Models\Asignatura;
use App\Models\Departamento;



class AsignaturaController extends Controller {





	public function getIndex()
	{
		$datos_asignaturas = Asignatura::join('departamentos','asignaturas.departamento_id','=','departamentos.id')
										  ->select('asignaturas.*','departamentos.nombre as departamento')
										  ->paginate();

		return view('Encargado/asignaturas/list',compact('datos_asignaturas'));
	}

	
	public function get_create(Request $request)
	{
	
			$departamentos = Departamento::paginate()->lists('nombre','id');
			return view('Encargado/asignaturas/create',compact('departamentos'));

		
	}

	public function post_store(Requests\CreateAsignaturaRequest $request)
	{
		
		$asignatura = new Asignatura();
		$asignatura->fill(['departamento_id' => $request->get('departamento'),'codigo' => $request->get('codigo'),
			'nombre' => $request->get('nombre'), 'descripcion' => $request->get('descripcion')]);
		$asignatura->save();

		Session::flash('message', 'La asignatura '.$asignatura->nombre.'  fue creada exitosamente!');
		return redirect()->action('Encargado\AsignaturaController@getIndex');
	
	}




	public function get_edit(Request $request)
	{
		
		$asignaturaEditable = Asignatura::findOrFail($request->get('id'));

		$id = $request->get('id');

		$departamentos = Departamento::paginate()->lists('nombre','id');

		return view('Encargado/asignaturas/edit', compact('asignaturaEditable','id','departamentos'));
	
	}



	public function put_update(Requests \EditAsignaturaRequest $request)
	{
	
		$asignatura = Asignatura::findOrFail($request->get('id'));
		$asignatura->fill(\Request::all());
		$asignatura->save();

		Session::flash('message', 'La asignatura '.$asignatura->nombre.' fue editada exitosamente!');

		return redirect()->action('Encargado\AsignaturaController@getIndex');
	}



	public function delete_destroy(Request $request)
		{

			$asignatura = Asignatura::findOrFail($request->get('id'));

			$asignatura->delete();


			Session::flash('message','La asignatura '.$asignatura->nombre.' fue eliminada');

			return redirect()->action('Encargado\AsignaturaController@getIndex');
			
		}


	public function get_search(Request $request)
	{
	
		if(trim($request->get('name')) != "")
		{

		$datos_asignaturas = Asignatura::join('departamentos','asignaturas.departamento_id','=','departamentos.id')
				->where('asignaturas.nombre', 'like' , '%'.$request->get('name').'%')
				->orWhere('departamentos.nombre','like', '%'.$request->get('name').'%')
				->orWhere('asignaturas.codigo','like','%'.$request->get('name').'%')
				->select('asignaturas.*','departamentos.nombre as departamento')
				->paginate();	

		return view('Encargado/asignaturas/list',compact('datos_asignaturas'));
		}

		else
		{

	 	return redirect()->action('Encargado\AsignaturaController@getIndex');

		}
	}


	public function get_depto()
	{
		$departamentos = Departamento::all()->lists('nombre','id');
		return view('Encargado/asignaturas/upload',compact('departamentos'));
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
					$asignatura = new Asignatura();
					$asignatura->fill(['departamento_id' => $departamento,'codigo' => $value->codigo,'nombre' =>$value->nombre,'descripcion' => $value->descripcion]);
					$asignatura->save();

				}

			})->get();
			Session::flash('message', 'Las asignaturas fueron agregadas exitosamente!');

	       return redirect()->action('Encargado\AsignaturaController@getIndex');
	}




}
