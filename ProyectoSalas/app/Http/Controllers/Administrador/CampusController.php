<?php namespace App\Http\Controllers\Administrador;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use Request;
use Illuminate\Support\Facades\Session;
use App\Models\Campus;
use App\Models\Rol_usuario;





class CampusController extends Controller {


	protected $layout='layouts.master';


	public function getIndex()
	{
		$campus = Campus::paginate();

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/campus/list',compact('campus','var'));
	}


	public function get_create()
	{
		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre'); 

        $encargados = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
					       	->where('roles.nombre','=','encargado')
					       	->select('roles_usuarios.*')
					       	->lists('roles_usuarios.rut','roles_usuarios.id');

		return view('Administrador/campus/create',compact('var','encargados'));
	}

	
	public function post_store(Requests\CreateCampusRequest $request)
	{
		
		$rut_encargado = Rol_usuario::where('id','=',$request->rut_encargado)->select('rut')->get();

		$campus = new Campus();
		
		foreach($rut_encargado as $rut){
			
			$campus->fill([
				'nombre' => $request->nombre,
				'direccion' => $request->direccion,
				'latitud' => $request->latitud,
				'longitud' => $request->longitud,
				'descripcion' => $request->descripcion,
				'rut_encargado' => $rut->rut]);
		}

		$campus->save();

		Session::flash('message', 'El campus ' .$campus->nombre.' fue creado');

		return redirect()->action('Administrador\CampusController@getIndex');
	}

	

		
	
	public function get_edit(Request $request)
	{
		
		$campusEditable = Campus::findOrFail($request->get('id'));
		$id = $request->get('id');

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/campus/edit', compact('campusEditable','id','var'));
	
	}

	public function put_update(Requests \EditCampusRequest $request)
	{
	
		$campusEditable = Campus::findOrFail($request->get('id'));
		$campusEditable->fill(\Request::all());
		$campusEditable->save();
		
		Session::flash('message','El campus '. $campusEditable->nombre. ' fue editado');

		return redirect()->action('Administrador\CampusController@getIndex');
	}


	public function delete_destroy(Request $request)
	{

		$campusEditable = Campus::findOrFail($request->get('id'));

		$campusEditable->delete();

		Session::flash('message','El campus '. $campusEditable->nombre. ' fue eliminado');

		return redirect()->action('Administrador\CampusController@getIndex');
		
	}



	public function get_search(Request $request)
	{
		if(is_numeric( (integer) $request->get('name')))
		{
			
			$name = array('name' => (integer) $request->get('name'));
			
			$rules = array('name' => 'max:8');


			$v =  \Validator::make($name,$rules);

			if($v->fails())
			 {
			 	Session::flash('message', 'No se encontraron resultados.');
				return redirect()->back();
			 }

		}

		if(trim($request->get('name')) != "")
		{

			$campus = Campus::where('nombre', 'like' , '%'.$request->get('name').'%')
					->orWhere('rut_encargado','=',(integer) $request->get('name'))
					->select('campus.*')
					->paginate();	
				
			$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

			
			if(!$campus->isEmpty())
			{
				return view('Administrador/campus/list',compact('campus','var'));
			}

			else
			{
				Session::flash('message', 'No se encontraron resultados.');
				return redirect()->back();
			}
		}

		else
		{

	 		return redirect()->action('Administrador\CampusController@getIndex');
	 	}
	}


	public function get_upload()
	{
		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/campus/upload',compact('var'));
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

					$rut = $value->rut_encargado;

					$encargado = Rol_usuario::where('rol_id','=','2')->where('rut','=',$rut)->pluck('rut');


					if(!is_null($encargado))
					{
						
						$nombre = Campus::where('nombre','=',$value->nombre)->pluck('nombre');

						if(is_null($nombre))
						{	
							
							$lat_long = Campus::where('latitud','=',$value->latitud)->where('longitud','=',$value->longitud)->first();

							if(is_null($lat_long))
							{
								$var = new Campus();

								$var->fill(['nombre' => $value->nombre,
									'direccion' => $value->direccion,
									'latitud' =>$value->latitud,
									'longitud' => $value->longitud,
									'descripcion' => $value->descripcion,
									'rut_encargado' => $rut
									]);

								$var->save();
							}
						
								continue;  				
						
						}
						
						continue;	
	       				
					}


				continue;


				}

			})->get();

			\Storage::delete($nombre);
		
		    return redirect()->action('Administrador\CampusController@getIndex');
	
	}



	public function get_download()
	{
		$var = Campus::all();

		\Excel::create('Campus',function($excel) use ($var)
		{
			$excel->sheet('Sheetname',function($sheet) use ($var)
			{
				$data=[];

				array_push($data, array('NOMBRE','DIRECCION','LATITUD','LONGITUD','DESCRIPCION','RUT_ENCARGADO'));

				foreach($var as $key => $v)
				{
					
					array_push($data, array($v->nombre,$v->direccion,$v->latitud,$v->longitud,$v->descripcion,$v->rut_encargado));

				}		
				$sheet->fromArray($data,null, 'A1', false,false);
			
			});
			
		})->download('xlsx');

			

	       return redirect()->action('Administrador\CampusController@getIndex');
	}

	


}
