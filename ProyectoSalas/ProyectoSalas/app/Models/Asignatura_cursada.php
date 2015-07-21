<?php namespace App\Models;


use Illuminate\Database\Eloquent\Model;



class Asignatura_cursada extends Model  {


	protected $table = 'asignaturas_cursadas';


	protected $fillable = ['curso_id', 'estudiante_id'];


}
