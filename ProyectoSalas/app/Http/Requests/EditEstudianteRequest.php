<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class EditEstudianteRequest extends Request {

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
			'carrera' => 'required|integer|not_in:0',
			'rut' => 'required|min:11|max:12|rut',
			'nombres' => 'required|space',
			'apellidos' => 'required|space',
			'email' => 'required|email|valid_email'
=======
			'carrera_id' => 'required|integer|not_in:0',
			'rut' => 'required|integer|unique:estudiantes,rut,'.$this->id,
			'nombres' => 'required|alpha',
			'apellidos' => 'required|alpha',
			'email' => 'required'
>>>>>>> d54c8fa948ab220500fe59fd7e40157631c5a416
		];
	}

}
