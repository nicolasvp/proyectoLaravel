<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateDocenteRequest extends Request {

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
			'departamento' => 'required|integer|not_in:0',
			'rut' => 'required|min:11|max:12|rut',
			'nombres' => 'required|space',
			'apellidos' => 'required|space',
			'email' => 'required|email|valid_email'
		];
	}

}
