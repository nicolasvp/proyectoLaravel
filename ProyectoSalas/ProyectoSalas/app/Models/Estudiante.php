<?php namespace App\Models;


use Illuminate\Database\Eloquent\Model;


class Estudiante extends Model  {

	
	protected $table = 'estudiantes';

	protected $fillable = ['carrera_id','rut','nombres','apellidos', 'email'];

	
	public function cursos()
	{

		return $this->belongsToMany('App\Models\Cursos','asignaturas_cursadas','estudiante_id','curso_id');

	}


	public function carreras()
	{

		return $this->belongsTo('App\Models\Carreras','carrera_id');
	}

}
