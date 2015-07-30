<?php namespace App\Http\Controllers\Administrador;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Docente;
use App\Models\Departamento;
use App\Models\Rol_usuario;
<<<<<<< HEAD
use App\Models\Usuario;
=======

>>>>>>> d54c8fa948ab220500fe59fd7e40157631c5a416



class DocenteController extends Controller {


	protected $layout='layouts.master';
	
	public function getIndex()
	{
			
		$datos_docentes = Docente::join('departamentos','docentes.departamento_id','=','departamentos.id')
						->select('docentes.*','departamentos.nombre as departamento')
						->paginate();

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/docentes/list',compact('datos_docentes','var'));
	}


	public function get_create()
	{

		$departamentos = Departamento::paginate()->lists('nombre','id');

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/docentes/create',compact('departamentos','var'));
	}


	public function post_store(Requests\CreateDocenteRequest $request)
	{
<<<<<<< HEAD


			$rut = array(
				'rut' => \App\RutUtils::rut($request->get('rut'))
				);
			
			$rules = array(
				'rut' => 'unique:docentes,rut'
			);
	
			$v =  \Validator::make($rut,$rules);


			if($v->fails())
			{
				return redirect()->back()
					->withErrors($v->errors())
					->withInput(\Request::all());
			}

			$rut = \App\RutUtils::rut($request->get('rut'));
	
			$var = new Usuario();

			$var->fill([
					'rut' => $rut,
					'email' => $request->get('email'),
					'nombres' => $request->get('nombres'), 
					'apellidos' => $request->get('apellidos')
					]);

			$var->save();
					

			$var2 = new Rol_usuario();
			
			$var2->fill([
					'rol_id' => '4',
					'rut' => $rut
					]);

			$var2->save();


			$var3 = new Docente();
			
			$var3->fill([
					'departamento_id' => $request->get('departamento'),
					'rut' => $rut,
					'nombres' => $request->get('nombres'),
					'apellidos' => $request->get('apellidos'),
					'email' => $request->get('email')
					]);

			$var3->save();		


		Session::flash('message', 'El docente '.$var3->nombres.' '.$var3->apellidos.' fue creado exitosamente!');

		return redirect()->action('Administrador\DocenteController@getIndex');
=======
		
		$docente= new Docente();
		$docente->fill(['departamento_id' => $request->get('departamento'), 'rut' => $request->get('rut'), 'nombres' => $request->get('nombres'),
			'apellidos' => $request->get('apellidos')]);
		$docente->save();

		Session::flash('message', 'El docente '.$docente->nombres.' '.$docente->apellidos.' fue creado exitosamente!');
		return redirect()->action('Administrador\DocenteController@getIndex');
	
>>>>>>> d54c8fa948ab220500fe59fd7e40157631c5a416
	}




<<<<<<< HEAD


=======
>>>>>>> d54c8fa948ab220500fe59fd7e40157631c5a416
	public function get_edit(Request $request)
	{
		
		$docenteEditable = Docente::findOrFail($request->get('id'));

<<<<<<< HEAD
		$rut = \App\RutUtils::formatear($docenteEditable->rut);

=======
>>>>>>> d54c8fa948ab220500fe59fd7e40157631c5a416
		$departamentos = Departamento::paginate()->lists('nombre','id');

		$id = $request->get('id');

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

<<<<<<< HEAD
		return view('Administrador/docentes/edit', compact('docenteEditable','rut','id','departamentos','var'));
=======
		return view('Administrador/docentes/edit', compact('docenteEditable','id','departamentos','var'));
>>>>>>> d54c8fa948ab220500fe59fd7e40157631c5a416
	
	}



	public function put_update(Requests \EditDocenteRequest $request)
	{

<<<<<<< HEAD
		$docente= Docente::findOrFail($request->get('id'));

		$rut = array(
			'rut' => \App\RutUtils::rut($request->get('rut'))
		);
			
		$rules = array(
				'rut' => 'unique:docentes,rut,'.$request->get('id')
				);
	
		$v =  \Validator::make($rut,$rules);


		if($v->fails())
		 {
			return redirect()->back()
					->withErrors($v->errors())
					->withInput(\Request::all());
		 }


		$rut = \App\RutUtils::rut($request->get('rut'));

		$usuario = Usuario::findOrFail($docente->rut);

		$usuario->fill([
				'rut' => $rut,
				'email' => $request->get('email'),
				'nombres' => $request->get('nombres'), 
				'apellidos' => $request->get('apellidos')
				]);

		$usuario->save();


		$docente->fill([
			'departamento_id' => $request->get('departamento'), 
			'rut' => $rut,
			'nombres' => $request->get('nombres'),
			'apellidos' => $request->get('apellidos'),
			'email' => $request->get('email')
						]);

		$docente->save();
		
		Session::flash('message', 'El docente '.$docente->nombres.' '.$docente->apellidos.' fue editado exitosamente!');
=======
		$estudiante = Docente::findOrFail($request->get('id'));
		$estudiante->fill(\Request::all());
		$estudiante->save();
		
		Session::flash('message', 'El estudiante '.$estudiante->nombres.' '.$estudiante->apellidos.' fue editado exitosamente!');
>>>>>>> d54c8fa948ab220500fe59fd7e40157631c5a416

		return redirect()->action('Administrador\DocenteController@getIndex');
	}


	public function delete_destroy(Request $request)
	{

<<<<<<< HEAD
		$docente = Usuario::findOrFail($request->get('rut'));
=======
		$docente = Docente::findOrFail($request->get('id'));
>>>>>>> d54c8fa948ab220500fe59fd7e40157631c5a416

		$docente->delete();


		Session::flash('message', 'El docente '.$docente->nombres.' '.$docente->apellidos.' fue eliminado exitosamente!');

		return redirect()->action('Administrador\DocenteController@getIndex');
		
	}

	public function get_search(Request $request)
		{
		
			if(trim($request->get('name')) != "")
			{

			 $datos_docentes = Docente::join('departamentos','docentes.departamento_id','=','departamentos.id')
			->where('docentes.rut', '=' , (integer) $request->get('name'))
			->orWhere('departamentos.nombre','like','%'.$request->get('name').'%')
			->select('docentes.*','departamentos.nombre as departamento')
			->paginate();

			$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

			return view('Administrador/docentes/list',compact('datos_docentes','var'));
			}

			else
			{

		 	return redirect()->action('Administrador\DocenteController@getIndex');

			}
		

		}


		public function get_deptos()
	{
		$departamentos = Departamento::all()->lists('nombre','id');

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/docentes/upload',compact('departamentos','var'));
	}

	public function post_upload(Request $request)
	{

<<<<<<< HEAD
	    
		   $file = $request->file('file');
	  
=======
	    // dd($request);
		   $file = $request->file('file');
	    //dd($file);
>>>>>>> d54c8fa948ab220500fe59fd7e40157631c5a416
	       $nombre = $file->getClientOriginalName();

	       \Storage::disk('local')->put($nombre,  \File::get($file));

			$departamento = $request->get('departamento');

			\Excel::load('/storage/app/'.$nombre,function($archivo) use ($departamento)
			{

				$result = $archivo->get();

				foreach($result as $key => $value)
				{
<<<<<<< HEAD

					$var = new Usuario();

					$var->fill([
						'rut' => $value->rut,
						'email' => $value->email,
						'nombres' => $value->nombres, 
						'apellidos' => $value->apellidos
						]);

					$var->save();
					

					$var2 = new Rol_usuario();
					$var2->fill([
						'rol_id' => '4',
						'rut' => $value->rut
						]);

					$var2->save();

					$var3 = new Docente();
					$var3->fill([
						'departamento_id' => $departamento,
						'rut' => $value->rut,
						'nombres' =>$value->nombres,
						'apellidos' => $value->apellidos,
						'email' => $value->email
						]);

					$var3->save();

=======
					$var = new Docente();
					$var->fill(['departamento_id' => $departamento,'rut' => $value->rut,'nombres' =>$value->nombres,'apellidos' => $value->apellidos]);
					$var->save();
>>>>>>> d54c8fa948ab220500fe59fd7e40157631c5a416

				}

			})->get();
			Session::flash('message', 'Los docentes fueron agregados exitosamente!');

	       return redirect()->action('Administrador\DocenteController@getIndex');
	}


}
