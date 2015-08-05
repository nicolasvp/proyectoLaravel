<?php namespace App\Http\Controllers\Encargado;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


use App\Models\Departamento;
use App\Models\Docente;
use App\Models\Rol_usuario;
use App\Models\Usuario;


class DocenteController extends Controller {

public function getIndex()
	{
			
		$datos_docentes = Docente::join('departamentos','docentes.departamento_id','=','departamentos.id')
						->select('docentes.*','departamentos.nombre as departamento')
						->paginate();

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre'); 

		return view('Encargado/docentes/list',compact('datos_docentes','var'));
	}


	public function get_create()
	{

		$departamentos = Departamento::paginate()->lists('nombre','id');

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre'); 

		return view('Encargado/docentes/create',compact('departamentos','var'));
	}


	public function post_store(Requests\CreateDocenteRequest $request)
	{
		
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

		Session::flash('message', 'El docente '.$var3->nombres.' '.$var3->apellidos.' fue agregado exitosamente!');

		return redirect()->action('Encargado\DocenteController@getIndex');
	
	}




	public function get_edit(Request $request)
	{
		
		$docenteEditable = Docente::findOrFail($request->get('id'));

		$rut = \App\RutUtils::formatear($docenteEditable->rut);

		$departamentos = Departamento::paginate()->lists('nombre','id');

		$id = $request->get('id');

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre'); 

		return view('Encargado/docentes/edit', compact('docenteEditable','rut','id','departamentos','var'));
	
	}



	public function put_update(Requests \EditDocenteRequest $request)
	{

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

		return redirect()->action('Encargado\DocenteController@getIndex');
	}


	public function delete_destroy(Request $request)
	{

		$docente = Usuario::findOrFail($request->get('rut'));

		$docente->delete();


		Session::flash('message', 'El docente '.$docente->nombres.' '.$docente->apellidos.' fue eliminado exitosamente!');

		return redirect()->action('Encargado\DocenteController@getIndex');
		
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

			return view('Encargado/docentes/list',compact('datos_docentes','var'));
			}

			else
			{

		 	return redirect()->action('Encargado\DocenteController@getIndex');

			}
		}


	public function get_deptos()
	{
		$departamentos = Departamento::paginate();

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

		return view('Encargado/docentes/upload',compact('departamentos','var'));
	}

	public function post_upload(Request $request)
	{

	    
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
						

						$var2 = new Rol_usuario();
						$var2->fill([
							'rol_id' => '4',
							'rut' => $rut
							]);

						$var2->save();

						$var3 = new Docente();
						$var3->fill([
							'departamento_id' => $value->departamento,
							'rut' => $rut,
							'nombres' =>$value->nombres,
							'apellidos' => $value->apellidos,
							'email' => $value->email
							]);

						$var3->save();
					}

				}

			})->get();
		

	       return redirect()->action('Encargado\DocenteController@getIndex');
	}

	public function get_download()
	{
		$var = Docente::all();

		\Excel::create('Docentes',function($excel) use ($var)
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

			

	       return redirect()->action('Encargado\DocenteController@getIndex');
	}


}
