<?php namespace App\Http\Controllers\Administrador;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Departamento;
use App\Models\Funcionario;
use App\Models\Rol_usuario;




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
		
		$funcionario= new Funcionario();
		$funcionario->fill($request->all());
		$funcionario->save();

		Session::flash('message', 'El funcionario '.$funcionario->nombres.' '.$funcionario->apellidos.' fue ingresado exitosamente!');

		return redirect()->action('Administrador\FuncionarioController@getIndex');
	
	}



	public function get_edit(Request $request)
	{
		
		$funcionarioEditable = Funcionario::findOrFail($request->get('id'));

		$departamentos = Departamento::paginate()->lists('nombre','id');

		$id = $request->get('id');


		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/funcionarios/edit', compact('funcionarioEditable','id','departamentos','var'));
	
	}



	public function put_update(Requests \EditFuncionarioRequest $request)
	{

		$funcionario = Funcionario::findOrFail($request->get('id'));
		$funcionario->fill(\Request::all());
		$funcionario->save();
		
		Session::flash('message', 'El funcionario '.$funcionario->nombres.' '.$funcionario->apellidos.' fue editado exitosamente!');

		return redirect()->action('Administrador\FuncionarioController@getIndex');
	}


	public function delete_destroy(Request $request)
	{

		$funcionario = Funcionario::findOrFail($request->get('id'));

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
						$var = new Funcionario();
						$var->fill(['departamento_id' => $departamento,'rut' => $value->rut,'nombres' => $value->nombres,'apellidos' =>$value->apellidos]);
						$var->save();

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
