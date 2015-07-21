<?php namespace App\Http\Controllers\Administrador;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use App\Models\Rol_usuario;
use App\Models\Rol;





class PerfilController extends Controller {


	protected $layout='layouts.master';


	public function getIndex()
	{
			
		return view('Administrador/perfiles/search');
	}

		public function get_show(Request $request)
	{
			

		$datos_usuario = Rol_usuario::join('roles', 'roles_usuarios.rol_id', '=','roles.id')
				->where('roles_usuarios.rut', '=', $request->get('rut'))
				->select('roles_usuarios.id','roles_usuarios.rut','roles.nombre')
				->get();

		$rut = $request->get('rut');

		$rol_usuario = Rol::paginate()->lists('nombre', 'id');

		//$rol_usuario = ['' => ''] + Roles::lists('nombre', 'id');	//agrega un null al principio

		return view('Administrador/perfiles/show',compact('datos_usuario','rol_usuario','rut'));
			
	}


	public function post_profile(Request $request)
	{
	

		$perfil = new Rol_usuario();
		$perfil->fill(['rut' => $request->get('rut'), 'rol_id' => $request->get('rol_asig')]);
		$perfil->save();

		Session::flash('message', 'El Perfil fue asignado exitosamente!');

		return redirect()->action('Administrador\PerfilController@getIndex');
	}

	public function delete_destroy(Request $request)
	{

		
		$profile = Rol_usuario::findOrFail($request->get('id'));

		$profile->delete();

		Session::flash('message', 'El Perfil fue removido exitosamente');

		return redirect()->action('Administrador\PerfilController@getIndex');

	}


	


}
