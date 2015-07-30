<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateCampusRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
	
		return [
<<<<<<< HEAD
			'nombre' => 'required|spaceNum|unique:campus,nombre',
=======
			'nombre' => 'required|space|unique:campus,nombre',
>>>>>>> d54c8fa948ab220500fe59fd7e40157631c5a416
			'direccion' => 'required|spaceNum',
			'latitud' => 'required|numeric|unique:campus,latitud',
			'longitud' => 'required|numeric|unique:campus,longitud',
			'rut_encargado' => 'required|integer'
		];
	}

}
