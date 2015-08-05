<?php namespace App\Http\Controllers\Administrador;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use Request;
use Illuminate\Support\Facades\Session;
use App\Models\Escuela;
use App\Models\Carrera;
use App\Models\Rol_usuario;



class CarreraController extends Controller {


	protected $layout='layouts.master';
	
	public function getIndex()
	{

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre'); 		

		$datos_carreras = Carrera::join('escuelas','carreras.escuela_id','=','escuelas.id')
						->select('carreras.*','escuelas.nombre as escuela')
						->paginate();

	
		return view('Administrador/carreras/list',compact('datos_carreras','var'));

	}


	public function get_create()
	{

		$escuelas = Escuela::paginate()->lists('nombre','id');

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/carreras/create',compact('escuelas','var'));
	}


	public function post_store(Requests \CreateCarreraRequest $request)
	{
		
		$carrera= new Carrera();
		$carrera->fill($request->all());
		$carrera->save();

		Session::flash('message', 'La carrera '.$carrera->nombre.' fue creada exitosamente!');
		return redirect()->action('Administrador\CarreraController@getIndex');
	
	}



	public function get_edit(Request $request)
	{
		
		$carreraEditable = Carrera::findOrFail($request->get('id'));

		$escuelas = Escuela::paginate()->lists('nombre','id');

		$id = $request->get('id');

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/carreras/edit', compact('carreraEditable','id','escuelas','var'));
	
	}



	public function put_update(Requests \EditCarreraRequest $request)
	{

		$carrera = Carrera::findOrFail($request->get('id'));
		$carrera->fill(\Request::all());
		$carrera->save();
		
		Session::flash('message', 'La carrera '.$carrera->nombre.' fue editada exitosamente!');

		return redirect()->action('Administrador\CarreraController@getIndex');
	}


	public function delete_destroy(Request $request)
	{

		$carrera = Carrera::findOrFail($request->get('id'));

		$carrera->delete();


		Session::flash('message', 'La carrera '.$carrera->nombre.' fue eliminada exitosamente!');

		return redirect()->action('Administrador\CarreraController@getIndex');
		
	}

	public function get_search(Request $request)
	{

		if(is_numeric((integer) $request->get('name')))
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

				$datos_carreras = Carrera::join('escuelas','carreras.escuela_id','=','escuelas.id')
									->where('carreras.nombre', 'like' , '%'.$request->get('name').'%')
									->orWhere('carreras.codigo','=',  (integer) $request->get('name'))
									->orWhere('escuelas.nombre','like', '%'.$request->get('name').'%')
									->select('carreras.*','escuelas.nombre as escuela')
									->paginate();

				$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre'); 

 		        if(!is_null($datos_carreras))
				{

					return view('Administrador/carreras/list',compact('datos_carreras','var'));
				}

				
					Session::flash('message', 'No se encontraron resultados.');

					return redirect()->back();
	

		}

		 	return redirect()->action('Administrador\CarreraController@getIndex');

		

	}


	public function get_escuela()
	{
		$escuelas = Escuela::paginate();

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/carreras/upload',compact('escuelas','var'));
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

					$escuela_id = Escuela::where('id','=',$value->escuela)->pluck('id');

					if(is_null($escuela_id))
					{
						continue;
					}

					$codigo = Carrera::where('codigo','=',$value->codigo)->pluck('id');

					if(!is_null($codigo))
					{
						continue;
					}

					$tupla = Carrera::where('codigo','=',$value->codigo)->where('nombre','=',$value->nombre)->pluck('id');

					if(is_null($tupla))
					{
						$var = new Carrera();

						$var->fill([
							'escuela_id' => $value->escuela,
							'codigo' => $value->codigo,
							'nombre' =>$value->nombre,
							'descripcion' => $value->descripcion
							]);

						$var->save();
					}

				}

			})->get();
	

	       return redirect()->action('Administrador\CarreraController@getIndex');
	}

	public function get_download()
	{
		$var = Carrera::all();

		\Excel::create('Carreras',function($excel) use ($var)
		{
			$excel->sheet('Sheetname',function($sheet) use ($var)
			{
				$data=[];

				array_push($data, array('ESCUELA','CODIGO','NOMBRE','DESCRIPCION'));

				foreach($var as $key => $v)
				{
					
					array_push($data, array($v->escuela_id,$v->codigo,$v->nombre,$v->descripcion));

				}		
				$sheet->fromArray($data,null, 'A1', false,false);
			
			});
			
		})->download('xlsx');

			

	       return redirect()->action('Administrador\CarreraController@getIndex');
	}




}
