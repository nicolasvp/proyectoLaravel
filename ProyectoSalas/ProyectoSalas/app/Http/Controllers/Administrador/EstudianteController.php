<?php namespace App\Http\Controllers\Administrador;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use Request;
use Illuminate\Support\Facades\Session;
use App\Models\Estudiante;
use App\Models\Carrera;





class EstudianteController extends Controller {


	protected $layout='layouts.master';
	

	public function getIndex()
	{
		$datos_estudiantes = Estudiante::join('carreras','estudiantes.carrera_id','=','carreras.id')
									->select('estudiantes.*','carreras.codigo as carrera')
									->paginate();

		return view('Administrador/estudiantes/list',compact('datos_estudiantes'));
	}



		public function get_create()
	{

		$carreras = Carrera::paginate()->lists('nombre','id');

		return view('Administrador/estudiantes/create',compact('carreras'));
	}


	public function post_store()
	{
		
		$estudiante = new Estudiante();
		$estudiante->fill(\Request::all());
		$estudiante->save();

		Session::flash('message', 'El estudiante '.$estudiante->nombres.' '.$estudiante->apellidos.' fue ingresado exitosamente!');
		return redirect()->action('Administrador\EstudianteController@getIndex');
	
	}





		public function get_edit(Request $request)
	{
		
		$estudianteEditable = Estudiante::findOrFail($request->get('id'));

		$carreras = Carrera::paginate()->lists('nombre','id');

		$id = $request->get('id');

		return view('Administrador/estudiantes/edit', compact('estudianteEditable','id','carreras'));
	
	}



	public function put_update(Request $request)
	{

		$estudiante = Estudiante::findOrFail($request->get('id'));
		$estudiante->fill(\Request::all());
		$estudiante->save();
		
		Session::flash('message', 'El estudiante '.$estudiante->nombres.' '.$estudiante->apellidos.' fue editado exitosamente!');

		return redirect()->action('Administrador\EstudianteController@getIndex');
	}


	public function delete_destroy(Request $request)
	{

		$estudiante = Estudiante::findOrFail($request->get('id'));

		$estudiante->delete();


		Session::flash('message', 'El estudiante '.$estudiante->nombres.' '.$estudiante->apellidos.' fue eliminado exitosamente!');

		return redirect()->action('Administrador\EstudianteController@getIndex');
		
	}

		public function get_search(Request $request)
		{
		
			if(trim($request->get('name')) != "")
			{

			 $datos_estudiantes = Estudiante::join('carreras','estudiantes.carrera_id','=','carreras.id')
			->where('estudiantes.rut', '=' , $request->get('name'))
			->orWhere('carreras.codigo','=', $request->get('name'))
			->select('estudiantes.*','carreras.codigo as carrera')
			->paginate();

			return view('Administrador/estudiantes/list',compact('datos_estudiantes'));
			}

			else
			{

		 	return redirect()->action('Administrador\EstudianteController@getIndex');

			}
		}


		public function get_carrera()
	{
		$carreras = Carrera::all()->lists('nombre','id');
		return view('Administrador/estudiantes/upload',compact('carreras'));
	}

	public function post_upload(Request $request)
	{

	    
		   $file = $request->file('file');
	    
	       $nombre = $file->getClientOriginalName();

	       \Storage::disk('local')->put($nombre,  \File::get($file));

			$carrera = $request->get('carrera');

			\Excel::load('/storage/app/'.$nombre,function($archivo) use ($carrera)
			{

				$result = $archivo->get();

				foreach($result as $key => $value)
				{
					$var = new Estudiante();
					$var->fill(['carrera_id' => $carrera,'rut' => $value->rut,'nombres' =>$value->nombres,'apellidos' => $value->apellidos,'email' =>$value->email]);
					$var->save();

				}

			})->get();
			Session::flash('message', 'Los alumnos fueron agregados exitosamente!');

	       return redirect()->action('Administrador\EstudianteController@getIndex');
	}	


}
