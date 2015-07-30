<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateFacultadRequest extends Request {

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
			'nombre' => 'required|space|unique:facultades,nombre',
=======
			'nombre' => 'required|alpha|unique:facultades,nombre',
>>>>>>> d54c8fa948ab220500fe59fd7e40157631c5a416
			'campus_id' => 'required|integer|not_in:0'
		];
	}

}
