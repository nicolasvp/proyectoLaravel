<?php namespace App\Http\Controllers\Administrador;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Campus;
use App\Models\Facultad;
use App\Models\Rol_usuario;




class FacultadController extends Controller {


	protected $layout='layouts.master';
	
	public function getIndex()
	{

		$datos_facultades = Facultad::join('campus','facultades.campus_id','=','campus.id')
							->select('facultades.*','campus.nombre as campus')
							->paginate();

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 
	
		return view('Administrador/facultades/list',compact('datos_facultades','var'));

	}


	public function get_create()
	{

		$campus = Campus::paginate()->lists('nombre','id');

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/facultades/create',compact('campus','var'));
	}


	public function post_store()
	{
		
		$facultad= new Facultad();
		$facultad->fill(\Request::all());
		$facultad->save();

		Session::flash('message', 'La facultad '.$facultad->nombre.' fue creada exitosamente!');

		return redirect()->action('Administrador\FacultadController@getIndex');
	
	}



	public function get_edit(Request $request)
	{
		
		$facultadEditable = Facultad::findOrFail($request->get('id'));

		$campus = Campus::paginate()->lists('nombre','id');

		$id = $request->get('id');

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/facultades/edit', compact('facultadEditable','id','campus','var'));
	
	}



	public function put_update(Requests \EditFacultadRequest $request)
	{

		$facultad = Facultad::findOrFail($request->get('id'));
		$facultad->fill(\Request::all());
		$facultad->save();
		
		Session::flash('message', 'La facultad '.$facultad->nombre.' fue editada exitosamente!');

		return redirect()->action('Administrador\FacultadController@getIndex');
	}


	public function delete_destroy(Request $request)
	{

		$facultad = Facultad::findOrFail($request->get('id'));

		$facultad->delete();


		Session::flash('message', 'La facultad '.$facultad->nombre.' fue eliminada exitosamente!');

		return redirect()->action('Administrador\FacultadController@getIndex');
		
	}


	public function get_search(Request $request)
	{
		
			if(trim($request->get('name')) != "")
			{

				 $datos_facultades = Facultad::join('campus','facultades.campus_id','=','campus.id')
				->where('facultades.nombre', 'like' ,'%'.$request->get('name').'%')
				->orWhere('campus.nombre','like', '%'.$request->get('name').'%')
				->select('facultades.*','campus.nombre as campus')
				->paginate();

				$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 



		        if(!$datos_facultades->isEmpty())
				{
					return view('Administrador/facultades/list',compact('datos_facultades','var'));
				}

				else
				{
					Session::flash('message', 'No se encontraron resultados.');
					return redirect()->back();
				}

			}

			else
			{

		 	return redirect()->action('Administrador\FacultadController@getIndex');

			}
	}


	public function get_campus()
	{
		$campus = Campus::paginate();

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/facultades/upload',compact('campus','var'));
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

						$nombre = Facultad::where('nombre','=',$value->nombre)->pluck('id');

						if(!is_null($nombre))
						{

							continue;

						}

						$campus_id = Campus::where('id','=',$value->campus)->pluck('id');

						if(!is_null($campus_id))
						{

							$var = new Facultad();

							$var->fill([
								'nombre' => $value->nombre,
								'campus_id' => $value->campus,
								'descripcion' =>$value->descripcion]);
							
							$var->save();

						}



					}

				})->get();
	

		       return redirect()->action('Administrador\FacultadController@getIndex');
	}

	public function get_download()
	{
		$var = Facultad::all();

		\Excel::create('Facultades',function($excel) use ($var)
		{
			$excel->sheet('Sheetname',function($sheet) use ($var)
			{
				$data=[];

				array_push($data, array('NOMBRE','CAMPUS','DESCRIPCION'));

				foreach($var as $key => $v)
				{
					
					array_push($data, array($v->nombre,$v->campus_id,$v->descripcion));

				}		
				$sheet->fromArray($data,null, 'A1', false,false);
			
			});
			
		})->download('xlsx');

			

	       return redirect()->action('Administrador\FacultadController@getIndex');
	}





}
