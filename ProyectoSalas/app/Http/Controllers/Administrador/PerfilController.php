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

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 
			
		return view('Administrador/perfiles/search',compact('var'));
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

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/perfiles/show',compact('datos_usuario','rol_usuario','rut','var'));
			
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


	public function get_pichula(Request $request)
	{
		//dd(\Request::all());		


            if($request->get('perfil') == 'administrador')
            {
                return redirect()->action('Administrador\AdministradorController@getIndex');
            }
            if($request->get('perfil') == 'encargado')
            {
                return redirect()->action('Encargado\EncargadoController@getIndex');
            }
            if($request->get('perfil') == 'estudiante')
            {

                return redirect()->action('AlumnoController@getIndex');
            }
            if($request->get('perfil') == 'docente')
            {
                return redirect()->action('DocenteController@getIndex');
            }

		return redirect()->action('Administrador\Administrador@getIndex');

	}


}
