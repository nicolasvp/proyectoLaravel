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
<<<<<<< HEAD
			'nombre' => 'required|spaceNum',
=======
			'nombre' => 'required|alpha_num',
>>>>>>> d54c8fa948ab220500fe59fd7e40157631c5a416
			'capacidad' => 'required|integer'
		];
	}

}
