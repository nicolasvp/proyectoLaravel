<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateCursoRequest extends Request {

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
			'asignatura' => 'required|integer|not_in:0',
			'docente' => 'required|integer|not_in:0',
			'semestre' => 'required|integer',
			'año' => 'required|integer',
			'seccion' => 'required|integer|unique:cursos,seccion,NULL,id,asignatura_id,'.$this->asignatura
		];
	}

}
