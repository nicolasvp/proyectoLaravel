<?php namespace App\Http\Controllers\Administrador;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use Request;
use Illuminate\Support\Facades\Session;
use App\Models\Rol_usuario;




class RolUsuarioController extends Controller {


	protected $layout='layouts.master';
	
	public function getIndex()
{
	$datos_roles = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
								->select('roles_usuarios.*','roles.nombre')
								->paginate();

	return view('Administrador/roles_usuarios/list',compact('datos_roles'));
}

	public function get_create()
	{
		return view('Administrador/roles_usuarios/create');
	}

	public function get_edit(Request $request)
	{
		
		$campusEditable = Campus::findOrFail($request->get('id'));
		$id = $request->get('id');

		return view('Administrador/roles_usuarios/edit', compact('rolEditable','id'));
	
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
		        ->where('roles.nombre','like','%'.$request->get('name').'%')
				->orWhere('rut', '=' , (integer) $request->get('name'))
				->select('roles_usuarios.*','roles.nombre')
				->paginate();	

		return view('Administrador/roles_usuarios/list',compact('datos_roles'));
		}

		else
		{

	 	return redirect()->action('Administrador\RolUsuarioController@getIndex');

		}
	}

}
