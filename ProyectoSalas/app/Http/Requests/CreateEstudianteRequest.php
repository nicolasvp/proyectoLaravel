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
			'rut' => 'required|min:11|max:12|rut',
			'nombres' => 'required|space',
			'apellidos' => 'required|space',
			'email' => 'required|email|valid_email'
		];
	}

}
