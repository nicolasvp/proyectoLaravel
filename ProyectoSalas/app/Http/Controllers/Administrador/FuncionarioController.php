<?php namespace App\Http\Controllers\Administrador;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Departamento;
use App\Models\Funcionario;
use App\Models\Rol_usuario;
<<<<<<< HEAD
use App\Models\Usuario;
=======
>>>>>>> d54c8fa948ab220500fe59fd7e40157631c5a416




class FuncionarioController extends Controller {


	protected $layout='layouts.master';
	
	public function getIndex()
	{

		$datos_funcionarios = Funcionario::join('departamentos','funcionarios.departamento_id','=','departamentos.id')
							->select('funcionarios.*','departamentos.nombre as departamento')
							->paginate();

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 


		return view('Administrador/funcionarios/list',compact('datos_funcionarios','var'));
	}

	public function get_create()
	{

		$departamentos = Departamento::paginate()->lists('nombre','id');


		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/funcionarios/create',compact('departamentos','var'));
	}


	public function post_store(Requests \CreateFuncionarioRequest $request)
	{
<<<<<<< HEAD

		$rut = array(
				'rut' => \App\RutUtils::rut($request->get('rut'))
				);
			
		$rules = array(
				'rut' => 'unique:funcionarios,rut'
				);
	
		$v =  \Validator::make($rut,$rules);


		if($v->fails())
		 {
			return redirect()->back()
					->withErrors($v->errors())
					->withInput(\Request::all());
		 }

		$rut = \App\RutUtils::rut($request->get('rut'));

		$usuario = new Usuario();

		$usuario->fill([
				'rut' => $rut,
				'email' => $request->get('email'),
				'nombres' => $request->get('nombres'), 
				'apellidos' => $request->get('apellidos')
				]);

		$usuario->save();

		$rol_usuario = new Rol_usuario();
			
		$rol_usuario->fill([
				'rol_id' => '2',
				'rut' => $rut
				]);

		$rol_usuario->save();
		
		$funcionario = new Funcionario();

		$funcionario->fill([
				'departamento_id' => $request->get('departamento'),
				'nombres' => $request->get('nombres'),
				'apellidos' => $request->get('apellidos'),
				'rut' => $rut,
				'email' => $request->get('email')
			]);
		
=======
		
		$funcionario= new Funcionario();
		$funcionario->fill($request->all());
>>>>>>> d54c8fa948ab220500fe59fd7e40157631c5a416
		$funcionario->save();

		Session::flash('message', 'El funcionario '.$funcionario->nombres.' '.$funcionario->apellidos.' fue ingresado exitosamente!');

		return redirect()->action('Administrador\FuncionarioController@getIndex');
	
	}



	public function get_edit(Request $request)
	{
		
		$funcionarioEditable = Funcionario::findOrFail($request->get('id'));

<<<<<<< HEAD
		$rut = \App\RutUtils::formatear($funcionarioEditable->rut);

=======
>>>>>>> d54c8fa948ab220500fe59fd7e40157631c5a416
		$departamentos = Departamento::paginate()->lists('nombre','id');

		$id = $request->get('id');


		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

<<<<<<< HEAD
		return view('Administrador/funcionarios/edit', compact('funcionarioEditable','rut','id','departamentos','var'));
=======
		return view('Administrador/funcionarios/edit', compact('funcionarioEditable','id','departamentos','var'));
>>>>>>> d54c8fa948ab220500fe59fd7e40157631c5a416
	
	}



	public function put_update(Requests \EditFuncionarioRequest $request)
	{

		$funcionario = Funcionario::findOrFail($request->get('id'));
<<<<<<< HEAD

		$rut = array(
			'rut' => \App\RutUtils::rut($request->get('rut'))
		);
			
		$rules = array(
				'rut' => 'unique:funcionarios,rut,'.$request->get('id')
				);
	
		$v =  \Validator::make($rut,$rules);


		if($v->fails())
		 {
			return redirect()->back()
					->withErrors($v->errors())
					->withInput(\Request::all());
		 }


		$rut = \App\RutUtils::rut($request->get('rut'));

		$usuario = Usuario::findOrFail($funcionario->rut);

		$usuario->fill([
				'rut' => $rut,
				'email' => $request->get('email'),
				'nombres' => $request->get('nombres'), 
				'apellidos' => $request->get('apellidos')
				]);

		$usuario->save();


		$funcionario->fill([
			'departamento_id' => $request->get('departamento'), 
			'rut' => $rut,
			'nombres' => $request->get('nombres'),
			'apellidos' => $request->get('apellidos'),
			'email' => $request->get('email')
						]);

=======
		$funcionario->fill(\Request::all());
>>>>>>> d54c8fa948ab220500fe59fd7e40157631c5a416
		$funcionario->save();
		
		Session::flash('message', 'El funcionario '.$funcionario->nombres.' '.$funcionario->apellidos.' fue editado exitosamente!');

		return redirect()->action('Administrador\FuncionarioController@getIndex');
	}


	public function delete_destroy(Request $request)
	{

<<<<<<< HEAD
		$funcionario = Usuario::findOrFail($request->get('rut'));
=======
		$funcionario = Funcionario::findOrFail($request->get('id'));
>>>>>>> d54c8fa948ab220500fe59fd7e40157631c5a416

		$funcionario->delete();


		Session::flash('message', 'El funcionario '.$funcionario->nombres.' '.$funcionario->apellidos.' fue eliminado exitosamente!');

		return redirect()->action('Administrador\FuncionarioController@getIndex');
		
	}

	public function get_depto()
	{
		$departamentos = Departamento::all()->lists('nombre','id');


		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

		return view ('Administrador/funcionarios/upload',compact('departamentos','var'));
	}

	public function post_upload(Request $request)
	{

		 
			   $file = $request->file('file');
		 
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

						$var2 = new Funcionario();

						$var2->fill([
							'departamento_id' => $departamento,
							'rut' => $value->rut,
							'nombres' => $value->nombres,
							'apellidos' =>$value->apellidos,
							'email' => $value->email
							]);

						$var2->save();

=======
						$var = new Funcionario();
						$var->fill(['departamento_id' => $departamento,'rut' => $value->rut,'nombres' => $value->nombres,'apellidos' =>$value->apellidos]);
						$var->save();

>>>>>>> d54c8fa948ab220500fe59fd7e40157631c5a416
					}

				})->get();
				Session::flash('message', 'Las funcionarios fueron agregados exitosamente!');

		       return redirect()->action('Administrador\FuncionarioController@getIndex');
	}
	public function get_search(Request $request)
		{
		
			if(trim($request->get('name')) != "")
			{

			 $datos_funcionarios = Funcionario::join('departamentos','funcionarios.departamento_id','=','departamentos.id')
			->where('funcionarios.rut', '=' , (integer) $request->get('name'))
			->orWhere('departamentos.nombre','like','%'.$request->get('name').'%')
			->select('funcionarios.*','departamentos.nombre as departamento')
			->paginate();


			$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

			return view('Administrador/funcionarios/list',compact('datos_funcionarios','var'));
			}

			else
			{

		 	return redirect()->action('Administrador\FuncionarioController@getIndex');

			}
		}

}
