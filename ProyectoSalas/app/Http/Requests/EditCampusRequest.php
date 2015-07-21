<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class EditCampusRequest extends Request {

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
			'nombre' => 'required|alpha|unique:campus,nombre,'. $this->id,
			'direccion' => 'required',
			'latitud' => 'required|numeric|unique:campus,latitud,'. $this->id,
			'longitud' => 'required|numeric|unique:campus,longitud,'. $this->id,
			'rut_encargado' => 'required|integer'
		];
	}

}
