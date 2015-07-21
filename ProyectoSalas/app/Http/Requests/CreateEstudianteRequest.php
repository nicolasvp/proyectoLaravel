<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateEstudianteRequest extends Request {

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
			'carrera' => 'required|integer|not_in:0',
			'rut' => 'required|integer|between:8,9|unique:estudiantes,rut',
			'nombres' => 'required|alpha',
			'apellidos' => 'required|alpha',
			'email' => 'required|email|valid_email'
		];
	}

}
