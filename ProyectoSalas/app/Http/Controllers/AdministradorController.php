<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
//use Request;

use Illuminate\Support\Facades\Session;

use App\Administrador;
use App\Roles_usuarios;
use App\Roles;



class AdministradorController extends Controller {


	protected $layout='layouts.master';


	public function getIndex()
	{
		$campus = Administrador::paginate();

		return view('Administrador/indexAdministrador',compact('campus'));
	}

	
	public function get_create()
	{
		return view('Administrador/create');
	}

	
	public function post_store()
	{
	
		$campus = new Administrador();
		$campus->fill(\Request::all());
		$campus->save();

		Session::flash('message', 'El campus ' .$campus->nombre.' fue creado');

		return redirect()->action('AdministradorController@getIndex');
	}

	
	public function get_show(Request $request)
	{
			

			//$usuarios = Roles_usuarios::usuario($request->get('rut'))->paginate();

		$datos_usuario = \DB::table('roles_usuarios')
				->join('roles', 'roles_usuarios.rol_id', '=','roles.id')
				->where('roles_usuarios.rut', '=', $request->get('rut'))
				->select('roles_usuarios.id','roles_usuarios.rut','roles.nombre')
				->get();

		$rut = $request->get('rut');

				$rol_usuario = \DB::table('roles')->lists('nombre', 'id');

		//$rol_usuario = ['' => ''] + Roles::lists('nombre', 'id');	//agrega un null al principio


				return view('Administrador.show',compact('datos_usuario','rol_usuario','rut'));
			
	}
		
	
	public function get_edit(Request $request)
	{
		
		$campusEditable = Administrador::findOrFail($request->get('id'));
		$id = $request->get('id');
		return view('Administrador/edit', compact('campusEditable','id'));
	
	}

	public function put_update(Request $request)
	{
	
		$campusEditable = Administrador::findOrFail($request->get('id'));
		$campusEditable->fill(\Request::all());
		$campusEditable->save();
		
		return redirect()->action('AdministradorController@getIndex');
	}


	public function delete_destroy(Request $request)
	{

		$campusEditable = Administrador::findOrFail($request->get('id'));

		$campusEditable->forceDelete();

		Session::flash('message','El campus '. $campusEditable->nombre. ' fue eliminado');

		return redirect()->action('AdministradorController@getIndex');
		
	}


	public function get_search()
	{
			
		return view('Administrador.search');
	}


	public function post_profile(Request $request)
	{
	

		\DB::table('roles_usuarios')->insert(
    	['rut' => $request->get('rut'), 'rol_id' => $request->get('rol_asig')]
   		);
		Session::flash('message', 'El Perfil fue asignado exitosamente!, por favor vuelva al menú');

		return redirect()->action('AdministradorController@get_show');
	}

	public function delete_rol(Request $request)
	{

		
		$profile = Roles_usuarios::findOrFail($request->get('id'));

		$profile->delete();

		Session::flash('message', 'El Perfil fue removido exitosamente');

		return redirect()->action('AdministradorController@get_show');

	}


	public function get_campus()
	{

		$campus = Administrador::paginate();


		return view('Administrador/campus_file',compact('campus'));

	}



	public function delete_campus(Request $request)
	{
		$file_campus = Administrador::findOrFail($request->get('id'));

		$file_campus->delete();	

		Session::flash('message', 'El campus fue archivado exitosamente!');

		return redirect()->action('AdministradorController@getIndex');

	}


	public function get_filed()
	{

		$filed_campus = Administrador::onlyTrashed()->paginate();

		return view('Administrador/campus_filed',compact('filed_campus'));
	}


	public function post_restore_campus(Request $request)
	{
		$restore_campus = Administrador::onlyTrashed()->where('id', $request->get('id'))->restore();
	
		Session::flash('message', 'El campus fue recuperado exitosamente!');

		return redirect()->action('AdministradorController@getIndex');
	}


	
}
