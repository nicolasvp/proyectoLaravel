<?php namespace App\Models;


use Illuminate\Database\Eloquent\Model;



class Escuela extends Model {



	protected $table = 'escuelas';

	protected $fillable = ['nombre', 'departamento_id','descripcion'];



}
