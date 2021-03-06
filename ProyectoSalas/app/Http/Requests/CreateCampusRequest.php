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
			'nombre' => 'required|spaceNum|unique:campus,nombre',
			'direccion' => 'required|spaceNum',
			'latitud' => 'required|numeric|unique:campus,latitud',
			'longitud' => 'required|numeric|unique:campus,longitud',
			'rut_encargado' => 'required|integer'
		];
	}

}
