<?php namespace App\Http\Controllers\Administrador;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


use App\Models\Curso;
use App\Models\Periodo;
use App\Models\Sala;
use App\Models\Campus;
use App\Models\Horario;
use App\Models\Tipo_sala;
use App\Models\Rol_usuario;

use Carbon\Carbon;





class SalaController extends Controller {


	protected $layout='layouts.master';


	public function getIndex()
	{

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 
		
		return view('Administrador/salas/index',compact('var'));
	}

	public function get_salas()
	{
		$datos_salas = Sala::join('campus','salas.campus_id','=','campus.id')
							->join('tipos_salas','salas.tipo_sala_id','=','tipos_salas.id')
							->select('salas.*','tipos_salas.nombre as tipo_sala','campus.nombre as campus')
							->paginate();

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/salas/list',compact('datos_salas','var'));

	}


	public function get_edit(Request $request)
	{

		$datos_sala = Sala::findOrFail($request->get('sala'));
		
		$id = $request->get('sala');
		
		$campus = Campus::paginate()->lists('nombre','id');

		$tipos_salas = Tipo_sala::paginate()->lists('nombre','id');
				
		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/salas/edit',compact('datos_sala','id','campus','tipos_salas','var'));
	}


	public function put_update(Requests \EditSalaAdminRequest $request)
	{

		$sala = Sala::findOrFail($request->get('id'));
		$sala->fill(['campus_id' => $request->get('campus'),'tipo_sala_id' => $request->get('tipo_sala'),'nombre' => $request->get('nombre'),
			'descripcion' => $request->get('descripcion'),'capacidad' => $request->get('capacidad')]);
		$sala->save();


		Session::flash('message', 'La sala '.$sala->nombre.' fue modificada exitosamente!');


		return redirect()->action('Administrador\SalaController@get_salas');
	}



	public function get_create()
	{

		$campus = Campus::paginate()->lists('nombre','id');
		$tipos_salas = Tipo_sala::paginate()->lists('nombre','id');

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/salas/create',compact('campus','tipos_salas','var'));
	}


	public function post_store(Requests \CreateSalaRequest $request)
	{
	
		$sala= new Sala();

		$sala->fill([
			'campus_id' => $request->get('campus'),
			'tipo_sala_id' => $request->get('tipo_sala'),
			'nombre' => $request->get('nombre'),
			'descripcion' => $request->get('descripcion'),
			'capacidad' => $request->get('capacidad')
			]);

		$sala->save();

		Session::flash('message', 'La sala '.$sala->nombre.' fue agregada exitosamente!');

		return redirect()->action('Administrador\SalaController@get_salas');
	
	}


	public function delete_destroy(Request $request)
	{

		$sala = Sala::findOrFail($request->get('sala'));

		$sala->delete();


		Session::flash('message', 'La sala '.$sala->nombre.' fue eliminada exitosamente!');

		return redirect()->action('Administrador\SalaController@get_salas');
	}


	public function get_search(Request $request)
	{

		if(trim($request->get('name')) != "")
		{

			$datos_salas  = Sala::join('campus','salas.campus_id','=','campus.id')
							->join('tipos_salas','salas.tipo_sala_id','=','tipos_salas.id')
							->where('campus.nombre','like','%'.$request->get('name').'%')
							->orWhere('tipos_salas.nombre','like','%'.$request->get('name').'%')
							->orWhere('salas.nombre','like','%'.$request->get('name').'%')
							->select('salas.*','campus.nombre as campus','tipos_salas.nombre as tipo_sala')
							->paginate();

			$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                            ->select('roles.*','roles_usuarios.*')
	                            ->lists('roles.nombre','roles.nombre'); 

			
				if(!$datos_salas->isEmpty())
				{
					return view('Administrador/salas/list',compact('datos_salas','var'));
				}

				else
				{
					Session::flash('message', 'No se encontraron resultados.');
					return redirect()->back();
				}
		}

		else
		{


			return redirect()->action('Administrador\SalaController@get_salas');

		}
	}


	public function get_upload()
	{

		$campus = Campus::all();

		$tipos = Tipo_sala::all();


		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
	                        ->where('roles_usuarios.rut','=', \Auth::user()->rut)
	                        ->select('roles.*','roles_usuarios.*')
	                        ->lists('roles.nombre','roles.nombre'); 

		return view('Administrador/salas/upload',compact('var','campus','tipos'));
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
					$campus_id = Campus::where('id','=',$value->campus)->pluck('id');

					if(is_null($campus_id))
					{
						continue;
					}

					$tipo_id = Tipo_sala::where('id','=',$value->tipo)->pluck('id');

					if(is_null($tipo_id))
					{
						continue;
					}

					$tupla = Sala::where('tipo_sala_id','=',$value->tipo)->where('nombre','=',$value->nombre)->first();

					if(is_null($tupla))
					{
						
							$var = new Sala();

							$var->fill([
								'campus_id' => $value->campus,
								'tipo_sala_id' => $value->tipo,
								'nombre' => $value->nombre,
								'descripcion' => $value->descripcion,
								'capacidad' => $value->capacidad
								]);

							$var->save();
					}
				

				}
						
	
	       				

			})->get();

			\Storage::delete($nombre);
		
		    return redirect()->action('Administrador\SalaController@get_salas');
	
	}





	public function get_download()
	{
		$var = Sala::all();

		\Excel::create('Salas',function($excel) use ($var)
		{
			$excel->sheet('Sheetname',function($sheet) use ($var)
			{
				$data=[];

				array_push($data, array('CAMPUS','TIPO_SALA','NOMBRE','DESCRIPCION','CAPACIDAD'));

				foreach($var as $key => $v)
				{
					
					array_push($data, array($v->campus_id,$v->tipo_sala_id,$v->nombre,$v->descripcion,$v->capacidad));

				}		
				$sheet->fromArray($data,null, 'A1', false,false);
			
			});
			
		})->download('xlsx');

			

	       return redirect()->action('Administrador\SalaController@get_salas');
	}



}
