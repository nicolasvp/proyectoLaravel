<?php namespace App\Http\Controllers\Administrador;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Periodo;
use App\Models\Rol_usuario;




class PeriodoController extends Controller {


	protected $layout='layouts.master';
	
	public function getIndex()
	{

		$datos_periodos = Periodo::paginate();

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/periodos/list',compact('datos_periodos','var'));
	}

	public function get_create()
	{
		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/periodos/create',compact('var'));
	}


	public function post_store(Requests \CreatePeriodoRequest $request)
	{

		$tupla = Periodo::where('inicio','=',$request->get('inicio'))->where('fin','=',$request->get('fin'))->pluck('id');

		if(is_null($tupla))
		{
			$periodo= new Periodo();
			$periodo->fill(\Request::all());
			$periodo->save();

			Session::flash('message', 'El periodo '.$periodo->bloque.' fue creado exitosamente!');

			return redirect()->action('Administrador\PeriodoController@getIndex');
		}

		Session::flash('message', 'Ya hay un periodo con ese inicio y fin');

		return redirect()->back()->withInput(\Request::all());
	
	}



	public function get_edit(Request $request)
	{
		
		$periodoEditable = Periodo::findOrFail($request->get('id'));


		$id = $request->get('id');

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/periodos/edit', compact('periodoEditable','id','var'));
	
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

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/periodos/upload',compact('var'));
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
						$var = new Periodo();
						$var->fill(['bloque' => $value->bloque,'inicio' => $value->inicio,'fin' => $value->fin]);
						$var->save();

					}

				})->get();
				Session::flash('message', 'Los períodos fueron agregados exitosamente!');

		       return redirect()->action('Administrador\PeriodoController@getIndex');
	}

}
