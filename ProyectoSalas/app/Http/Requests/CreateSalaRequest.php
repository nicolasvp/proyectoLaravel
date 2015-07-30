<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateSalaRequest extends Request {

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
			'campus' => 'required|integer|not_in:0',
			'tipo_sala' => 'required|integer|not_in:0',
			'nombre' => 'required|spaceNum',
			'capacidad' => 'required|integer'
		];
	}

}
