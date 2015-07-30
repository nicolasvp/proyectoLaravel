<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class EditAsignaturaRequest extends Request {

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
			'codigo' => 'required|unique:asignaturas,codigo,'. $this->id,
<<<<<<< HEAD
			'nombre' => 'required|spaceNum'
=======
			'nombre' => 'required|alpha'
>>>>>>> d54c8fa948ab220500fe59fd7e40157631c5a416
		];
	}

}
