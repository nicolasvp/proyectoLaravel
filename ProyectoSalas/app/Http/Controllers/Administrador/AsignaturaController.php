<?php namespace App\Http\Controllers\Administrador;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use Request;
use Illuminate\Support\Facades\Session;

use App\Models\Asignatura;
use App\Models\Departamento;
use App\Models\Rol_usuario;





class AsignaturaController extends Controller {


	protected $layout='layouts.master';

	public function getIndex()
	{
		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre');  

        return view('Administrador/asignaturas/index',compact('var'));                  
	}


	public function get_asignaturas()
	{

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre');  

		$datos_asignaturas = Asignatura::join('departamentos','asignaturas.departamento_id','=','departamentos.id')
										  ->select('asignaturas.*','departamentos.nombre as departamento')
										  ->paginate();

		return view('Administrador/asignaturas/list',compact('datos_asignaturas','var'));
	}

	public function get_create()
	{

		$departamentos = Departamento::paginate()->lists('nombre','id');

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre');  

		return view('Administrador/asignaturas/create',compact('departamentos','var'));
	}


	public function post_store(Requests\CreateAsignaturaRequest $request)
	{
	
		$asignatura = new Asignatura();
		$asignatura->fill(['departamento_id' => $request->get('departamento'),'codigo' => $request->get('codigo'),
			'nombre' => $request->get('nombre'), 'descripcion' => $request->get('descripcion')]);
		$asignatura->save();

		Session::flash('message', 'La asignatura '.\Request::get('nombre').' fue creada exitosamente!');
		return redirect()->action('Administrador\AsignaturaController@get_asignaturas');
	
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

		return view('Administrador/asignaturas/edit', compact('asignaturaEditable','id','departamentos','var'));
	
	}



	public function put_update(Requests \EditAsignaturaRequest $request)
	{
	
		$asignatura = Asignatura::findOrFail($request->get('id'));
		$asignatura->fill(\Request::all());
		$asignatura->save();
		
		Session::flash('message','La asignatura '.\Request::get('nombre').' fue editada');

		return redirect()->action('Administrador\AsignaturaController@get_asignaturas');
	}


	public function delete_destroy(Request $request)
	{

		$asignatura = Asignatura::findOrFail($request->get('id'));

		$asignatura->delete();


		Session::flash('message','La asignatura '.$asignatura->nombre.' fue eliminada');

		return redirect()->action('Administrador\AsignaturaController@get_asignaturas');
		
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

	
			if(!$datos_asignaturas->isEmpty())
			{
				return view('Administrador/asignaturas/list',compact('datos_asignaturas','var'));
			}

			
				Session::flash('message', 'No se encontraron resultados.');
				return redirect()->back();
		
		}		

	 	return redirect()->action('Administrador\AsignaturaController@get_asignaturas');

		
	}


	public function get_depto()
	{
		$departamentos = Departamento::paginate();

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre');  

		return view('Administrador/asignaturas/upload',compact('departamentos','var'));
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

					$depto_id = Departamento::where('id','=',$value->departamento)->pluck('id');

					if(is_null($depto_id))
					{
						continue;
					}

					$codigo = Asignatura::where('codigo','=',$value->codigo)->pluck('id');

					if(is_null($codigo))
					{	
						$var = new Asignatura();

						$var->fill([
							'departamento_id' => $value->departamento,
							'codigo' => $value->codigo,
							'nombre' =>$value->nombre,
							'descripcion' => $value->descripcion
							]);

						$var->save();
					}
				}

			})->get();
	

	       return redirect()->action('Administrador\AsignaturaController@get_asignaturas');



	}




	public function get_download()
	{
		$var = Asignatura::all();

		\Excel::create('Asignaturas',function($excel) use ($var)
		{
			$excel->sheet('Sheetname',function($sheet) use ($var)
			{
				$data=[];

				array_push($data, array('DEPARTAMENTO','CODIGO','NOMBRE','DESCRIPCION'));

				foreach($var as $key => $v)
				{
					
					array_push($data, array($v->departamento_id,$v->codigo,$v->nombre,$v->descripcion));

				}		
				$sheet->fromArray($data,null, 'A1', false,false);
			
			});
			
		})->download('xlsx');

			

	       return redirect()->action('Administrador\AsignaturaController@get_asignaturas');
	}
	


}
