<?php namespace App\Http\Controllers\Administrador;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Rol_usuario;




class RolUsuarioController extends Controller {


	protected $layout='layouts.master';
	
	public function getIndex()
	{
		$datos_roles = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
<<<<<<< HEAD
								->join('usuarios','roles_usuarios.rut','=','usuarios.rut')
								->select('roles_usuarios.*','roles.nombre as rol','usuarios.*')
=======
								->select('roles_usuarios.*','roles.nombre')
>>>>>>> d54c8fa948ab220500fe59fd7e40157631c5a416
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
	
		if(trim($request->get('name')) != "")
		{

		$datos_roles = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
<<<<<<< HEAD
				->join('usuarios','roles_usuarios.rut','=','usuarios.rut')
		        ->where('roles.nombre','like','%'.$request->get('name').'%')
				->orWhere('roles_usuarios.rut', '=' , (integer) $request->get('name'))
				->orWhere('usuarios.nombres','like','%'.$request->get('name').'%')
				->orWhere('usuarios.apellidos','like','%'.$request->get('name').'%')
				->select('roles_usuarios.*','roles.nombre as rol','usuarios.*')
=======
		        ->where('roles.nombre','like','%'.$request->get('name').'%')
				->orWhere('rut', '=' , (integer) $request->get('name'))
				->select('roles_usuarios.*','roles.nombre')
>>>>>>> d54c8fa948ab220500fe59fd7e40157631c5a416
				->paginate();	

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/roles_usuarios/list',compact('datos_roles','var'));
		}

		else
		{

	 	return redirect()->action('Administrador\RolUsuarioController@getIndex');

		}
	}

}