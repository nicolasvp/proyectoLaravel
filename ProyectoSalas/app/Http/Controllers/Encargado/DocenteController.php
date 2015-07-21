<?php namespace App\Http\Controllers\Encargado;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


use App\Models\Departamento;
use App\Models\Docente;


class DocenteController extends Controller {

public function getIndex()
	{
			
		$datos_docentes = Docente::join('departamentos','docentes.departamento_id','=','departamentos.id')
						->select('docentes.*','departamentos.nombre as departamento')
						->paginate();

		return view('Encargado/docentes/list',compact('datos_docentes'));
	}


	public function get_create()
	{

		$departamentos = Departamento::paginate()->lists('nombre','id');

		return view('Encargado/docentes/create',compact('departamentos'));
	}


	public function post_store(Requests\CreateDocenteRequest $request)
	{
		
		$docente= new Docente();
		$docente->fill(['departamento_id' => $request->get('departamento'), 'rut' => $request->get('rut'), 'nombres' => $request->get('nombres'),
			'apellidos' => $request->get('apellidos')]);
		$docente->save();

		Session::flash('message', 'El docente '.$docente->nombres.' '.$docente->apellidos.' fue agregado exitosamente!');

		return redirect()->action('Encargado\DocenteController@getIndex');
	
	}




	public function get_edit(Request $request)
	{
		
		$docenteEditable = Docente::findOrFail($request->get('id'));

		$departamentos = Departamento::paginate()->lists('nombre','id');

		$id = $request->get('id');

		return view('Encargado/docentes/edit', compact('docenteEditable','id','departamentos'));
	
	}



	public function put_update(Requests \EditDocenteRequest $request)
	{

		$docente = Docente::findOrFail($request->get('id'));
		$docente->fill(\Request::all());
		$docente->save();
		
		Session::flash('message', 'El docente '.$docente->nombres.' '.$docente->apellidos.' fue editado exitosamente!');

		return redirect()->action('Encargado\DocenteController@getIndex');
	}


	public function delete_destroy(Request $request)
	{

		$docente = Docente::findOrFail($request->get('id'));

		$docente->delete();


		Session::flash('message', 'El docente '.$docente->nombres.' '.$docente->apellidos.' fue eliminado exitosamente!');

		return redirect()->action('Encargado\DocenteController@getIndex');
		
	}

	public function get_search(Request $request)
		{
		
			if(trim($request->get('name')) != "")
			{

			 $datos_docentes = Docente::join('departamentos','docentes.departamento_id','=','departamentos.id')
			->where('docentes.rut', '=' , (integer) $request->get('name'))
			->orWhere('departamentos.nombre','like','%'.$request->get('name').'%')
			->select('docentes.*','departamentos.nombre as departamento')
			->paginate();

			return view('Encargado/docentes/list',compact('datos_docentes'));
			}

			else
			{

		 	return redirect()->action('Encargado\DocenteController@getIndex');

			}
		}


	public function get_departamentos()
	{
		$departamentos = Departamento::all()->lists('nombre','id');
		return view('Encargado/docentes/upload',compact('departamentos'));
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
					$docentes = new Docente();
					$docentes->fill(['departamento_id' => $departamento,'rut' => $value->rut,'nombres' =>$value->nombres,'apellidos' => $value->apellidos]);
					$docentes->save();

				}

			})->get();
			Session::flash('message', 'Los docentes fueron agregados exitosamente!');

	       return redirect()->action('Encargado\DocenteController@getIndex');
	}

}
