<?php namespace App\Http\Controllers\Administrador;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use Request;
use Illuminate\Support\Facades\Session;
use App\Models\Escuela;
use App\Models\Carrera;
use App\Models\Rol_usuario;



class CarreraController extends Controller {


	protected $layout='layouts.master';
	
	public function getIndex()
	{

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre'); 		

		$datos_carreras = Carrera::join('escuelas','carreras.escuela_id','=','escuelas.id')
						->select('carreras.*','escuelas.nombre as escuela')
						->paginate();

	
		return view('Administrador/carreras/list',compact('datos_carreras','var'));

	}


	public function get_create()
	{

		$escuelas = Escuela::paginate()->lists('nombre','id');

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/carreras/create',compact('escuelas','var'));
	}


	public function post_store(Requests \CreateCarreraRequest $request)
	{
		
		$carrera= new Carrera();
		$carrera->fill($request->all());
		$carrera->save();

		Session::flash('message', 'La carrera '.$carrera->nombre.' fue creada exitosamente!');
		return redirect()->action('Administrador\CarreraController@getIndex');
	
	}



	public function get_edit(Request $request)
	{
		
		$carreraEditable = Carrera::findOrFail($request->get('id'));

		$escuelas = Escuela::paginate()->lists('nombre','id');

		$id = $request->get('id');

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/carreras/edit', compact('carreraEditable','id','escuelas','var'));
	
	}



	public function put_update(Requests \EditCarreraRequest $request)
	{

		$carrera = Carrera::findOrFail($request->get('id'));
		$carrera->fill(\Request::all());
		$carrera->save();
		
		Session::flash('message', 'La carrera '.$carrera->nombre.' fue editada exitosamente!');

		return redirect()->action('Administrador\CarreraController@getIndex');
	}


	public function delete_destroy(Request $request)
	{

		$carrera = Carrera::findOrFail($request->get('id'));

		$carrera->delete();


		Session::flash('message', 'La carrera '.$carrera->nombre.' fue eliminada exitosamente!');

		return redirect()->action('Administrador\CarreraController@getIndex');
		
	}

	public function get_escuela()
	{
		$escuelas = Escuela::all()->lists('nombre','id');

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/carreras/upload',compact('escuelas','var'));
	}

	public function post_upload(Request $request)
	{

	 
		   $file = $request->file('file');
	 
	       $nombre = $file->getClientOriginalName();

	       \Storage::disk('local')->put($nombre,  \File::get($file));

			$escuela = $request->get('escuela');

			\Excel::load('/storage/app/'.$nombre,function($archivo) use ($escuela)
			{

				$result = $archivo->get();

				foreach($result as $key => $value)
				{
					$var = new Carrera();
					$var->fill(['escuela_id' => $escuela,'codigo' => $value->codigo,'nombre' =>$value->nombre,'descripcion' => $value->descripcion]);
					$var->save();

				}

			})->get();
			Session::flash('message', 'Las carreras fueron agregadas exitosamente!');

	       return redirect()->action('Administrador\CarreraController@getIndex');
	}

	public function get_search(Request $request)
		{
		
			if(trim($request->get('name')) != "")
			{

			 $datos_carreras = Carrera::join('escuelas','carreras.escuela_id','=','escuelas.id')
			->where('carreras.nombre', '=' ,  $request->get('name'))
			->orWhere('carreras.codigo','=',  (integer) $request->get('name'))
			->orWhere('escuelas.nombre','=', $request->get('name'))
			->select('carreras.*','escuelas.nombre as escuela')
			->paginate();

			$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre'); 

			return view('Administrador/carreras/list',compact('datos_carreras','var'));
			}

			else
			{

		 	return redirect()->action('Administrador\CarreraController@getIndex');

			}
		}

}
