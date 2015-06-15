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

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */




	public function index()
	{
		$campus = Administrador::paginate();

		return view('Administrador/indexAdministrador',compact('campus'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('Administrador.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
	
		$campus = new Administrador();
		$campus->fill(\Request::all());
		$campus->save();

		Session::flash('message', $campus->nombre.' fue creado');

		return redirect()->route('Administrador.index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show(Request $request)
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
		
			/**)
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
	
		$campusEditable = Administrador::findOrFail($id);

		return view('Administrador.edit', compact('campusEditable'));
	
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$campusEditable = Administrador::findOrFail($id);

		$campusEditable->fill(\Request::all());
		$campusEditable->save();
		
		return redirect()->route('Administrador.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{

		$campusEditable = Administrador::findOrFail($id);

		$campusEditable->forceDelete();

		Session::flash('message', $campusEditable->nombre. ' fue eliminado');

		return redirect()->route('Administrador.index');
		
	}


	public function getSearch()
	{
			
		return view('Administrador.search');
	}


	public function postProfile(Request $request)
	{
	

		\DB::table('roles_usuarios')->insert(
    	['rut' => $request->get('rut'), 'rol_id' => $request->get('rol_asig')]
   		);
		Session::flash('message', 'El Perfil fue asignado exitosamente!, por favor vuelva al menú');

		return redirect()->route('Administrador.show');
	}

	public function deleteRol(Request $request)
	{

		
		$profile = Roles_usuarios::findOrFail($request->get('id'));

		$profile->delete();

		Session::flash('message', 'El Perfil fue removido exitosamente');

		return redirect()->route('Administrador.show');

	}


	public function getCampus_list()
	{

		$campus = Administrador::paginate();


		return view('Administrador/deleteCampus',compact('campus'));

	}

	public function deleteCampus(Request $request)
	{
		$file_campus = Administrador::findOrFail($request->get('id'));

		$file_campus->delete();	

		Session::flash('message', 'El campus fue archivado exitosamente!');

		return redirect()->route('Administrador.index');

	}


	public function getFiled_list()
	{

		$filed_campus = Administrador::onlyTrashed()->paginate();

		return view('Administrador/deletedCampus',compact('filed_campus'));
	}

	public function postRestore_campus(Request $request)
	{
		$restore_campus = Administrador::onlyTrashed()->where('id', $request->get('id'))->restore();
	
		Session::flash('message', 'El campus fue recuperado exitosamente!');

		return redirect()->route('Administrador.index');
	}


	
}
