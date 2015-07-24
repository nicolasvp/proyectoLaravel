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
		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre');  

		return view('Administrador/campus/campus_index',compact('var'));
	}

	public function get_list()
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

		return view('Administrador/campus/create',compact('var'));
	}

	
	public function post_store(Requests\CreateCampusRequest $request)
	{
	
		$campus = new Campus();
		$campus->fill($request->all());
		$campus->save();

		Session::flash('message', 'El campus ' .$campus->nombre.' fue creado');

		return redirect()->action('Administrador\CampusController@get_list');
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

		return redirect()->action('Administrador\CampusController@get_list');
	}


	public function delete_destroy(Request $request)
	{

		$campusEditable = Campus::findOrFail($request->get('id'));

		$campusEditable->forceDelete();

		Session::flash('message','El campus '. $campusEditable->nombre. ' fue eliminado');

		return redirect()->action('Administrador\CampusController@get_list');
		
	}



	public function get_search(Request $request)
	{
	
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

		return view('Administrador/campus/list',compact('campus','var'));
		}

		else
		{

	 	return redirect()->action('Administrador\CampusController@get_list');

		}
	}



    //ARCHIVAR CAMPUS

	public function delete_campus(Request $request)
	{
		$file_campus = Campus::findOrFail($request->get('id'));

		$file_campus->delete();	

		Session::flash('message', 'El campus fue archivado exitosamente!');

		return redirect()->action('Administrador\CampusController@get_list');

	}


	public function get_filed()
	{

		$filed_campus = Campus::onlyTrashed()->paginate();

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/campus/campus_filed',compact('filed_campus','var'));
	}


	public function post_restore_campus(Request $request)
	{
		$restore_campus = Campus::onlyTrashed()->where('id', $request->get('id'))->restore();
	
		Session::flash('message', 'El campus fue recuperado exitosamente!');

		return redirect()->action('Administrador\CampusController@getIndex');
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
					$var = new Campus();
					$var->fill(['nombre' => $value->nombre,'direccion' => $value->direccion,'latitud' =>$value->latitud,'longitud' => $value->longitud,
						'descripcion' => $value->descripcion,'rut_encargado' => $value->rut_encargado]);
					$var->save();

				}

			})->get();
			Session::flash('message', 'Los campus fueron agregados exitosamente!');

	       return redirect()->action('Administrador\CampusController@get_list');
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

			

	       return redirect()->action('Administrador\CampusController@get_list');
	}

	


}
