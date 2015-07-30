<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class EditFuncionarioRequest extends Request {

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
			'departamento' => 'required|integer|not_in:0',
			'rut' => 'required|min:11|max:12|rut',
			'nombres' => 'required|space',
			'apellidos' => 'required|space',
			'email' => 'required|email|valid_email'
=======
			'departamento_id' => 'required|integer|not_in:0',
			'rut' => 'required|integer|unique:funcionarios,rut,'.$this->id,
			'nombres' => 'required|alpha',
			'apellidos' => 'required|alpha'

>>>>>>> d54c8fa948ab220500fe59fd7e40157631c5a416
		];
	}

}
