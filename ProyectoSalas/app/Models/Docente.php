<?php namespace App\Models;


use Illuminate\Database\Eloquent\Model;


class Docente extends Model{


	protected $table = 'docentes';

	
	protected $fillable = ['departamento_id','rut','nombres', 'apellidos','email'];


}
