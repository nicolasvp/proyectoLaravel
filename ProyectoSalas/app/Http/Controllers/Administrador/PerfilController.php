<?php namespace App\Http\Controllers\Administrador;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use App\Models\Rol_usuario;
use App\Models\Rol;
use App\Models\Usuario;
use App\Models\Docente;
use App\Models\Estudiante;
use App\Models\Departamento;
use App\Models\Carrera;





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
		
		$rules = array(
			'rut' => 'integer'
		);	

		$this->validate($request, $rules);

		if(trim($request->get('rut')) != "")
		{
		
		$roles_usuario = Rol_usuario::join('roles', 'roles_usuarios.rol_id', '=','roles.id')
				->join('usuarios','roles_usuarios.rut','=','usuarios.rut')
				->where('roles_usuarios.rut', '=', $request->get('rut'))
				->select('roles_usuarios.id','roles_usuarios.rut','roles.nombre as rol','usuarios.nombres','usuarios.apellidos','usuarios.email')
				->get();

		$datos_usuario = Usuario::where('rut','=',$request->get('rut'))->get();

		$rut = $request->get('rut');

		$rol_usuario = Rol::paginate()->lists('nombre', 'id');


		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/perfiles/show',compact('roles_usuario','rol_usuario','rut','datos_usuario','var'));
		}

		else
		{

		 return redirect()->action('Administrador\PerfilController@getIndex');

		}
	}


	public function post_profile(Request $request)
	{
	

		$rut = $request->get('rut');
		$rol = $request->get('rol_asig');

		$tabla = Rol::where('id','=',$rol)->select('nombre')->get();

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                         ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                         ->select('roles.*','roles_usuarios.*')
	                         ->lists('roles.nombre','roles.nombre'); 

		foreach($tabla as $tab)
		{

			if($tab->nombre == 'docente')
			{
				$departamentos = Departamento::all()->lists('nombre','id');
				return view ('Administrador/perfiles/departamentos',compact('departamentos','rut','rol','var'));
			}

			if($tab->nombre == 'estudiante')
			{
				$carreras = Carrera::all()->lists('nombre','id');
				return view ('Administrador/perfiles/carreras',compact('carreras','rut','rol','var'));
			}

		}

		$perfil = new Rol_usuario();
		$perfil->fill(['rut' => $rut, 'rol_id' => $rol]);
		$perfil->save();


		Session::flash('message', 'El Perfil fue asignado exitosamente!');

		return redirect()->action('Administrador\RolUsuarioController@getIndex');
	}


	public function post_docente(Requests \SelectDeptoRequest $request)
	{

		$datos = Usuario::where('rut','=',$request->get('rut'))->get();

		$docente = new Docente();

		foreach($datos as $dato)
		{
			$docente->fill([
				'departamento_id' => $request->get('departamento'),
				'nombres' => $dato->nombres,
				'apellidos' => $dato->apellidos,
				'rut' => $dato->rut,
				'email' => $dato->email
				]);
			$docente->save();
		}


		$perfil = new Rol_usuario();
		$perfil->fill(['rut' => $request->get('rut'), 'rol_id' => $request->get('rol')]);
		$perfil->save();

		Session::flash('message', 'El Perfil fue asignado exitosamente!');

		return redirect()->action('Administrador\RolUsuarioController@getIndex');
	}


	public function post_estudiante(Requests \SelectCarreraRequest $request)
	{

		$datos = Usuario::where('rut','=',$request->get('rut'))->get();

		$estudiante = new Estudiante();

		foreach($datos as $dato)
		{
			$estudiante->fill([
				'carrera_id' => $request->get('carrera'),
				'nombres' => $dato->nombres,
				'apellidos' => $dato->apellidos,
				'email' => $dato->email,
				'rut' => $dato->rut
				]);

			$estudiante->save();
		}


		$perfil = new Rol_usuario();
		$perfil->fill(['rut' => $request->get('rut'), 'rol_id' => $request->get('rol')]);
		$perfil->save();

		Session::flash('message', 'El Perfil fue asignado exitosamente!');

		return redirect()->action('Administrador\RolUsuarioController@getIndex');
	}


	public function delete_destroy(Request $request)
	{

		$tabla = Rol::join('roles_usuarios','roles.id','=','roles_usuarios.rol_id')
						->where('roles_usuarios.id','=',$request->get('id'))
						->select('roles.nombre')
						->get();

		$rut = Rol_usuario::where('id','=',$request->get('id'))->select('rut')->get();

		foreach($tabla as $tab)
		{

			if($tab->nombre == 'docente')
			{
				foreach($rut as $r)
				{
					$docente = Docente::where('rut','=',$r->rut)->delete();
				}		
			}

			if($tab->nombre == 'estudiante')
			{
				foreach($rut as $r)
				{
					$estudiante = Estudiante::where('rut','=',$r->rut)->delete();
				}	
			}
		}

		$profile = Rol_usuario::findOrFail($request->get('id'));

		$profile->delete();



		Session::flash('message', 'El Perfil fue removido exitosamente');

		return redirect()->action('Administrador\RolUsuarioController@getIndex');

	}

	public function get_cambioPerfil(Request $request)
	{
	

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
