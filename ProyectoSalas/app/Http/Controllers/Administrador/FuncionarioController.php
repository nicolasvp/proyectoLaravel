<?php namespace App\Http\Controllers\Administrador;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Departamento;
use App\Models\Funcionario;
use App\Models\Rol_usuario;
use App\Models\Usuario;




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
		
		$funcionario->save();

		Session::flash('message', 'El funcionario '.$funcionario->nombres.' '.$funcionario->apellidos.' fue ingresado exitosamente!');

		return redirect()->action('Administrador\FuncionarioController@getIndex');
	
	}



	public function get_edit(Request $request)
	{
		
		$funcionarioEditable = Funcionario::findOrFail($request->get('id'));

		$rut = \App\RutUtils::formatear($funcionarioEditable->rut);

		$departamentos = Departamento::paginate()->lists('nombre','id');

		$id = $request->get('id');


		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/funcionarios/edit', compact('funcionarioEditable','rut','id','departamentos','var'));
	
	}



	public function put_update(Requests \EditFuncionarioRequest $request)
	{

		$funcionario = Funcionario::findOrFail($request->get('id'));

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

		$funcionario->save();
		
		Session::flash('message', 'El funcionario '.$funcionario->nombres.' '.$funcionario->apellidos.' fue editado exitosamente!');

		return redirect()->action('Administrador\FuncionarioController@getIndex');
	}


	public function delete_destroy(Request $request)
	{

		$funcionario = Usuario::findOrFail($request->get('rut'));

		$funcionario->delete();


		Session::flash('message', 'El funcionario '.$funcionario->nombres.' '.$funcionario->apellidos.' fue eliminado exitosamente!');

		return redirect()->action('Administrador\FuncionarioController@getIndex');
		
	}

	public function get_search(Request $request)
	{
		
		if(is_numeric( (integer) $request->get('name')))
		{
			
			$name = array('name' => (integer) $request->get('name'));
			
			$rules = array('name' => 'max:8');


			$v =  \Validator::make($name,$rules);

			if($v->fails())
			 {
			 	Session::flash('message', 'No se encontraron resultados.');
				return redirect()->back();
			 }

		}

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
		
	         if(!$datos_funcionarios->isEmpty())
				{
					return view('Administrador/funcionarios/list',compact('datos_funcionarios','var'));
				}

				else
				{
					Session::flash('message', 'No se encontraron resultados.');
					return redirect()->back();
				}


			
			}

			else
			{

		 	return redirect()->action('Administrador\FuncionarioController@getIndex');

			}
		}


	public function get_depto()
	{
		$departamentos = Departamento::paginate();


		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

		return view ('Administrador/funcionarios/upload',compact('departamentos','var'));
	}

	public function post_upload(Request $request)
	{

	     if(is_null($request->file('file')))
	     {
	     	Session::flash('message', 'Debes seleccionar un archivo.');

			return redirect()->back();
		 }
		 		 
			   $file = $request->file('file');
		 
		       $nombre = $file->getClientOriginalName();

		       \Storage::disk('local')->put($nombre,  \File::get($file));


				\Excel::load('/storage/app/'.$nombre,function($archivo)
				{

					$result = $archivo->get();

					foreach($result as $key => $value)
					{

						$rut_valido = \App\RutUtils::isRut($value->rut);

						if(!$rut_valido)
						{
							continue;
						}

						$rut = \App\RutUtils::rut($value->rut);

						$depto_id = Departamento::where('id','=',$value->departamento)->pluck('id');
						
						if(is_null($depto_id))
						{
							continue;
						}

						$tupla = Usuario::where('rut','=',$rut)->where('email','=',$value->email)->first();

						if(is_null($tupla))
						{

							$var = new Usuario();

							$var->fill([
								'rut' => $rut,
								'email' => $value->email,
								'nombres' => $value->nombres, 
								'apellidos' => $value->apellidos
								]);

							$var->save();

							$var2 = new Funcionario();

							$var2->fill([
								'departamento_id' => $value->departamento,
								'rut' => $rut,
								'nombres' => $value->nombres,
								'apellidos' =>$value->apellidos,
								'email' => $value->email
								]);

							$var2->save();
						}
					}

				})->get();
			

		       return redirect()->action('Administrador\FuncionarioController@getIndex');
	}

	public function get_download()
	{
		$var = Funcionario::all();

		\Excel::create('Funcionarios',function($excel) use ($var)
		{
			$excel->sheet('Sheetname',function($sheet) use ($var)
			{
				$data=[];

				array_push($data, array('DEPARTAMENTO','NOMBRES','APELLIDOS','RUT','EMAIL'));

				foreach($var as $key => $v)
				{
					$a = \App\RutUtils::dv($v->rut);
					$rut = $v->rut."-".$a;
					
					array_push($data, array($v->departamento_id,$v->nombres,$v->apellidos,$rut,$v->email));

				}		
				$sheet->fromArray($data,null, 'A1', false,false);
			
			});
			
		})->download('xlsx');

			

	       return redirect()->action('Administrador\FuncionarioController@getIndex');
	}


}
