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
			'departamento_id' => 'required|integer|not_in:0',
			'rut' => 'required|integer|unique:funcionarios,rut,'.$this->id,
			'nombres' => 'required|alpha',
			'apellidos' => 'required|alpha'

		];
	}

}
