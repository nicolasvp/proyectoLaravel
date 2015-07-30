<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Carrera extends Model {


	protected $table = 'carreras';

	protected $fillable = ['escuela_id','codigo','nombre','descripcion'];



	public function estudiantes()
	{

		return $this->hasMany('App\Models\Estudiantes','carrera_id');
	}

}
