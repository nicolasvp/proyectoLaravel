<?php namespace App\Models;


use Illuminate\Database\Eloquent\Model;



class Horarios extends Model {



	protected $table = 'horarios';

	
	protected $fillable = ['sala_id','periodo_id','curso_id','dia_id'];




}
