<?php namespace App\Models;


use Illuminate\Database\Eloquent\Model;



class Asignaturas extends Model {


	protected $table = 'asignaturas';

	protected $fillable = ['departamento_id','codigo','nombre', 'descripcion'];

	
	public function cursos()
	{

		return $this->hasMany('App\Models\Cursos','asignatura_id');
	}


}
