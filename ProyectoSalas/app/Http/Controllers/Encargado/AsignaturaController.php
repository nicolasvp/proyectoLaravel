<?php namespace App\Http\Controllers\Encargado;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


use App\Models\Asignatura;
use App\Models\Departamento;
use App\Models\Rol_usuario;



class AsignaturaController extends Controller {





	public function getIndex()
	{
		$datos_asignaturas = Asignatura::join('departamentos','asignaturas.departamento_id','=','departamentos.id')
										  ->select('asignaturas.*','departamentos.nombre as departamento')
										  ->paginate();

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre'); 

		return view('Encargado/asignaturas/list',compact('datos_asignaturas','var'));
	}

	
	public function get_create(Request $request)
	{
	
		$departamentos = Departamento::paginate()->lists('nombre','id');

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre'); 

			return view('Encargado/asignaturas/create',compact('departamentos','var'));

		
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

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre'); 

		return view('Encargado/asignaturas/edit', compact('asignaturaEditable','id','departamentos','var'));
	
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

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre'); 

		return view('Encargado/asignaturas/list',compact('datos_asignaturas','var'));
		}

		else
		{

	 	return redirect()->action('Encargado\AsignaturaController@getIndex');

		}
	}


	public function get_depto()
	{
		$departamentos = Departamento::all()->lists('nombre','id');

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre'); 

		return view('Encargado/asignaturas/upload',compact('departamentos','var'));
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
<<<<<<< HEAD

					$asignatura->fill([
						'departamento_id' => $departamento,
						'codigo' => $value->codigo,
						'nombre' =>$value->nombre,
						'descripcion' => $value->descripcion
						]);
					
=======
					$asignatura->fill(['departamento_id' => $departamento,'codigo' => $value->codigo,'nombre' =>$value->nombre,'descripcion' => $value->descripcion]);
>>>>>>> d54c8fa948ab220500fe59fd7e40157631c5a416
					$asignatura->save();

				}

			})->get();
			Session::flash('message', 'Las asignaturas fueron agregadas exitosamente!');

	       return redirect()->action('Encargado\AsignaturaController@getIndex');
	}




}
