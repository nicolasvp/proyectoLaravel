<?php namespace App\Http\Controllers\Administrador;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use Request;
use Illuminate\Support\Facades\Session;
use App\Models\Departamento;
use App\Models\Facultad;




class DepartamentoController extends Controller {


	protected $layout='layouts.master';
	
	public function getIndex()
	{

		$datos_departamentos = Departamento::join('facultades','departamentos.facultad_id','=','facultades.id')
							->select('departamentos.*','facultades.nombre as facultad')
							->paginate();

	
		return view('Administrador/departamentos/list',compact('datos_departamentos'));

	}


	public function get_create()
	{

		$facultades = Facultad::paginate()->lists('nombre','id');

		return view('Administrador/departamentos/create',compact('facultades'));
	}


	public function post_store(Requests \CreateDepartamentoRequest $request)
	{
		
		$departamento= new Departamento();
		$departamento->fill($request->all());
		$departamento->save();

		Session::flash('message', 'El departamento '.$departamento->nombre.' fue creado exitosamente!');

		return redirect()->action('Administrador\DepartamentoController@getIndex');
	
	}



	public function get_edit(Request $request)
	{
		
		$departamentoEditable = Departamento::findOrFail($request->get('id'));

		$facultades = Facultad::paginate()->lists('nombre','id');

		$id = $request->get('id');

		return view('Administrador/departamentos/edit', compact('departamentoEditable','id','facultades'));
	
	}



	public function put_update(Requests \EditDepartamentoRequest $request)
	{

		$departamento = Departamento::findOrFail($request->get('id'));
		$departamento->fill(\Request::all());
		$departamento->save();
		
		Session::flash('message', 'El departamento '.$departamento->nombre.' fue editado exitosamente!');

		return redirect()->action('Administrador\DepartamentoController@getIndex');
	}


	public function delete_destroy(Request $request)
	{

		$departamento = Departamento::findOrFail($request->get('id'));

		$departamento->delete();


		Session::flash('message', 'El departamento '.$departamento->nombre.' fue eliminado exitosamente!');

		return redirect()->action('Administrador\DepartamentoController@getIndex');
		
	}


	public function get_facultades()
	{

		$facultades = Facultad::all()->lists('nombre','id');
		return view('Administrador/departamentos/upload',compact('facultades'));
	}
	
	public function post_upload(Request $request)
	{

	 
		   $file = $request->file('file');
	 
	       $nombre = $file->getClientOriginalName();

	       \Storage::disk('local')->put($nombre,  \File::get($file));

			$facultad = $request->get('facultad');

			\Excel::load('/storage/app/'.$nombre,function($archivo) use ($facultad)
			{

				$result = $archivo->get();

				foreach($result as $key => $value)
				{
					$var = new Departamento();
					$var->fill(['nombre' => $value->nombre,'facultad_id' => $facultad,'descripcion' =>$value->descripcion]);
					$var->save();

				}

			})->get();
			Session::flash('message', 'Los departamentos fueron agregados exitosamente!');

	       return redirect()->action('Administrador\DepartamentoController@getIndex');
	}


	public function get_search(Request $request)
		{
		
			if(trim($request->get('name')) != "")
			{

			 $datos_departamentos = Departamento::join('facultades','departamentos.facultad_id','=','facultades.id')
			->where('departamentos.nombre', 'like' ,'%'.$request->get('name').'%')
			->orWhere('facultades.nombre','like', '%'.$request->get('name').'%')
			->select('departamentos.*','facultades.nombre as facultad')
			->paginate();

			return view('Administrador/departamentos/list',compact('datos_departamentos'));
			}

			else
			{

		 	return redirect()->action('Administrador\DepartamentoController@getIndex');

			}
		}

}
