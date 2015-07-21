<?php namespace App\Models;


use Illuminate\Database\Eloquent\Model;


class Curso extends Model  {



	protected $table = 'cursos';

	protected $fillable = ['asignatura_id', 'docente_id', 'semestre', 'anio', 'seccion'];

	
	public function estudiantes()
	{

		return $this->belongsToMany('App\Models\Estudiantes','asignaturas_cursadas','curso_id','estudiante_id');
		
	}




	public function asignatura()
	{

		return $this->belongsTo('App\Models\Asignaturas');
	}
	

}
