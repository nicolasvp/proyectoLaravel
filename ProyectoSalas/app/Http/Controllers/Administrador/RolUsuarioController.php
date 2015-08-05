<?php namespace App\Http\Controllers\Administrador;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Rol_usuario;
use App\Models\Rol;




class RolUsuarioController extends Controller {


	protected $layout='layouts.master';
	
	public function getIndex()
	{
		$datos_roles = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
								->join('usuarios','roles_usuarios.rut','=','usuarios.rut')
								->select('roles_usuarios.*','roles.nombre as rol','usuarios.*')
								->paginate();

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

	return view('Administrador/roles_usuarios/list',compact('datos_roles','var'));
	}

	public function get_create()
	{

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/roles_usuarios/create',compact('var'));
	}

	public function get_edit(Request $request)
	{
		
		$campusEditable = Campus::findOrFail($request->get('id'));
		$id = $request->get('id');

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/roles_usuarios/edit', compact('rolEditable','id','var'));
	
	}
	public function delete_destroy(Request $request)
	{

		$rolEditable = Rol_usuario::findOrFail($request->get('id'));

		$rolEditable->forceDelete();

		Session::flash('message','El campus '. $rolEditable->nombre. ' fue eliminado');

		return redirect()->action('Administrador\RolUsuarioController@get_list');
		
	}

	public function get_search(Request $request)
	{

		

	
			if(is_numeric((integer) $request->get('name')))
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

			$datos_roles = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
					->join('usuarios','roles_usuarios.rut','=','usuarios.rut')
			        ->where('roles.nombre','like','%'.$request->get('name').'%')
					->orWhere('roles_usuarios.rut', '=' , (integer) $request->get('name'))
					->orWhere('usuarios.nombres','like','%'.$request->get('name').'%')
					->orWhere('usuarios.apellidos','like','%'.$request->get('name').'%')
					->select('roles_usuarios.*','roles.nombre as rol','usuarios.*')
					->paginate();	
	
			$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

		
			    if(!$datos_roles->isEmpty())
				{
					return view('Administrador/roles_usuarios/list',compact('datos_roles','var'));
				}

				else
				{
					Session::flash('message', 'No se encontraron resultados.');
					return redirect()->back();
				}
		}

		else
		{

	 		return redirect()->action('Administrador\RolUsuarioController@getIndex');

		}
	}



	public function get_download()
	{
		$var = Rol_usuario::all();

		\Excel::create('Roles_usuarios',function($excel) use ($var)
		{
			$excel->sheet('Sheetname',function($sheet) use ($var)
			{
				$data=[];

				array_push($data, array('ROL','RUT'));

				foreach($var as $key => $v)
				{
					$a = \App\RutUtils::dv($v->rut);
					$rut = $v->rut."-".$a;
					
					array_push($data, array($v->rol_id,$rut));

				}		
				$sheet->fromArray($data,null, 'A1', false,false);
			
			});
			
		})->download('xlsx');

			

	       return redirect()->action('Administrador\RolUsuarioController@getIndex');
	}

}
