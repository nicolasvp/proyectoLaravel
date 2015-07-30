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
<<<<<<< HEAD
			'rut' => 'required|min:11|max:12|rut',
=======
			'rut' => 'required|integer|unique:estudiantes,rut',
>>>>>>> d54c8fa948ab220500fe59fd7e40157631c5a416
			'nombres' => 'required|space',
			'apellidos' => 'required|space',
			'email' => 'required|email|valid_email'
		];
	}

}
