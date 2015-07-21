<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class EditFacultadRequest extends Request {

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
			'nombre' => 'required|alpha|unique:facultades,nombre,'.$this->id,
			'campus_id' => 'required|integer|not_in:0'
		];
	}

}
