<?php namespace App\Http\Controllers\Administrador;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Departamento;
use App\Models\Escuela;
use App\Models\Rol_usuario;




class EscuelaController extends Controller {


	protected $layout='layouts.master';
	
	public function getIndex()
	{

		$datos_escuelas = Escuela::join('departamentos','escuelas.departamento_id','=','departamentos.id')
						->select('escuelas.*','departamentos.nombre as departamento')
						->paginate();

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 
	
		return view('Administrador/escuelas/list',compact('datos_escuelas','var'));

	}


	public function get_create()
	{

		$departamentos = Departamento::paginate()->lists('nombre','id');

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/escuelas/create',compact('departamentos','var'));
	}


	public function post_store(Requests \CreateEscuelaRequest $request)
	{
		
		$escuela= new Escuela();
		$escuela->fill($request->all());
		$escuela->save();

		Session::flash('message', 'La escuela '.$escuela->nombre.' fue creada exitosamente!');

		return redirect()->action('Administrador\EscuelaController@getIndex');
	
	}



	public function get_edit(Request $request)
	{
		
		$escuelaEditable = Escuela::findOrFail($request->get('id'));

		$departamentos = Departamento::paginate()->lists('nombre','id');

		$id = $request->get('id');

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/escuelas/edit', compact('escuelaEditable','id','departamentos','var'));
	
	}



	public function put_update(Requests \EditEscuelaRequest $request)
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

	public function get_search(Request $request)
	{
		
			if(trim($request->get('name')) != "")
			{

				 $datos_escuelas = Escuela::join('departamentos','escuelas.departamento_id','=','departamentos.id')
					->where('escuelas.nombre', 'like' ,'%'.$request->get('name').'%')
					->orWhere('departamentos.nombre','like', '%'.$request->get('name').'%')
					->select('escuelas.*','departamentos.nombre as departamento')
					->paginate();

				$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 


		        if(!$datos_escuelas->isEmpty())
				{
					return view('Administrador/escuelas/list',compact('datos_escuelas','var'));
				}

				else
				{
					Session::flash('message', 'No se encontraron resultados.');
					return redirect()->back();
				}

			}

			else
			{

		 		return redirect()->action('Administrador\EscuelaController@getIndex');

			}
	}


	public function get_depto()
	{
		$departamentos = Departamento::paginate();

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/escuelas/upload',compact('departamentos','var'));
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

					$departamento_id = Departamento::where('id','=',$value->departamento)->pluck('id');

					if(is_null($departamento_id))
					{
						continue;
					}

					$tupla = Escuela::where('nombre','=',$value->nombre)->where('departamento_id','=',$value->departamento)->first();

					if(is_null($tupla))
					{
						$var = new Escuela();

						$var->fill([
							'nombre' => $value->nombre,
							'departamento_id' => $value->departamento,
							'descripcion' =>$value->descripcion
							]);

						$var->save();
					}
				}

			})->get();
			

	       return redirect()->action('Administrador\EscuelaController@getIndex');
	}

	public function get_download()
	{
		$var = Escuela::all();

		\Excel::create('Escuelas',function($excel) use ($var)
		{
			$excel->sheet('Sheetname',function($sheet) use ($var)
			{
				$data=[];

				array_push($data, array('NOMBRE','DEPARTAMENTO','DESCRIPCION'));

				foreach($var as $key => $v)
				{
					
					array_push($data, array($v->nombre,$v->departamento_id,$v->descripcion));

				}		
				$sheet->fromArray($data,null, 'A1', false,false);
			
			});
			
		})->download('xlsx');

			

	       return redirect()->action('Administrador\EscuelaController@getIndex');
	}


}
