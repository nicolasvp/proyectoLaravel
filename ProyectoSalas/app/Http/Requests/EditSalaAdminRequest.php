<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class EditSalaAdminRequest extends Request {

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
			'nombre' => 'required|spaceNum',
=======
			'nombre' => 'required|alpha_num',
>>>>>>> d54c8fa948ab220500fe59fd7e40157631c5a416
			'capacidad' => 'required|integer',
			'campus' => 'required|integer',
			'tipo_sala' => 'required|integer'

		];
	}

}