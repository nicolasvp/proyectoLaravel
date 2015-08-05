<?php namespace App\Http\Controllers\Administrador;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use Request;
use Illuminate\Support\Facades\Session;
use App\Models\Departamento;
use App\Models\Facultad;
use App\Models\Rol_usuario;




class DepartamentoController extends Controller {


	protected $layout='layouts.master';
	
	public function getIndex()
	{

		$datos_departamentos = Departamento::join('facultades','departamentos.facultad_id','=','facultades.id')
							->select('departamentos.*','facultades.nombre as facultad')
							->paginate();

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

	
		return view('Administrador/departamentos/list',compact('datos_departamentos','var'));

	}


	public function get_create()
	{

		$facultades = Facultad::paginate()->lists('nombre','id');

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/departamentos/create',compact('facultades','var'));
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

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/departamentos/edit', compact('departamentoEditable','id','facultades','var'));
	
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

	public function get_search(Request $request)
	{
		
			if(trim($request->get('name')) != "")
			{

			 $datos_departamentos = Departamento::join('facultades','departamentos.facultad_id','=','facultades.id')
			->where('departamentos.nombre', 'like' ,'%'.$request->get('name').'%')
			->orWhere('facultades.nombre','like', '%'.$request->get('name').'%')
			->select('departamentos.*','facultades.nombre as facultad')
			->paginate();

			$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

			
		        if(!$datos_departamentos->isEmpty())
				{
					return view('Administrador/departamentos/list',compact('datos_departamentos','var'));
				}

				else
				{
					Session::flash('message', 'No se encontraron resultados.');
					return redirect()->back();
				}


			}

			else
			{

		 	return redirect()->action('Administrador\DepartamentoController@getIndex');

			}
	}

	public function get_facultades()
	{

		$facultades = Facultad::paginate();

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/departamentos/upload',compact('facultades','var'));
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
					$facultad_id = Facultad::where('id','=',$value->facultad)->pluck('id');

					if(is_null($facultad_id))
					{
						continue;
					}

					$tupla = Departamento::where('nombre','=',$value->nombre)->where('facultad_id','=',$value->facultad)->first();

					if(is_null($tupla))
					{
						$var = new Departamento();
						
						$var->fill([
							'nombre' => $value->nombre,
							'facultad_id' => $value->facultad,
							'descripcion' =>$value->descripcion
							]);

						$var->save();
					}
				}

			})->get();
	

	       return redirect()->action('Administrador\DepartamentoController@getIndex');
	}


	public function get_download()
	{
		$var = Departamento::all();

		\Excel::create('Departamentos',function($excel) use ($var)
		{
			$excel->sheet('Sheetname',function($sheet) use ($var)
			{
				$data=[];

				array_push($data, array('NOMBRE','FACULTAD','DESCRIPCION'));

				foreach($var as $key => $v)
				{
					
					array_push($data, array($v->nombre,$v->facultad_id,$v->descripcion));

				}		
				$sheet->fromArray($data,null, 'A1', false,false);
			
			});
			
		})->download('xlsx');

			

	       return redirect()->action('Administrador\DepartamentoController@getIndex');
	}

}
