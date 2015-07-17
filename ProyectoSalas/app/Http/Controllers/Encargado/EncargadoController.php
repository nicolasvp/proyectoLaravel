<?php namespace App\Http\Controllers\Encargado;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use App\Models\Estudiante;



class EncargadoController extends Controller {


	protected $layout='layouts.master';


	public function getIndex()
	{

		return view('Encargado/indexEncargado');

	}



/*---------------------------------------D O W N L O A D----------------------------------------------------------*/

	public function get_download()
	{
		$es = Estudiante::join('carreras','estudiantes.carrera_id','=','carreras.id')
							->select('estudiantes.*','carreras.nombre','carreras.codigo')
							->get();
		//dd($es);

		\Excel::create('Estudiantes',function($excel) use ($es)
		{
			$excel->sheet('Sheetname',function($sheet) use ($es)
			{
				$data=[];

				array_push($data, array('CARRERA','RUT','NOMBRES','APELLIDOS','EMAIL'));

				foreach($es as $key => $e)
				{
					
					array_push($data, array($e->codigo,$e->rut,$e->nombres,$e->apellidos,$e->email));

				}		
				$sheet->fromArray($data,null, 'A1', false,false);
			
			});
			
		})->download('xlsx');

			dd('++++');

		return ('bajado');
	}



}
