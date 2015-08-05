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
										  ->join('facultades','departamentos.facultad_id','=','facultades.id')
										  ->join('campus','facultades.campus_id','=','campus.id')
										  ->where('campus.rut_encargado','=',\Auth::user()->rut)
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
		$departamentos = Departamento::paginate();

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre'); 

		return view('Encargado/asignaturas/upload',compact('departamentos','var'));
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
	

	       return redirect()->action('Encargado\AsignaturaController@getIndex');



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

			

	       return redirect()->action('Encargado\AsignaturaController@getIndex');
	}
	




}
