<?php namespace App\Models;


use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Campus extends Model  {

	
	use SoftDeletes;


	protected $table = 'campus';

	protected $dates = ['deleted_at'];

	protected $fillable = ['nombre', 'direccion', 'latitud', 'longitud', 'rut_encargado' , 'descripcion'];


	public function facultades()
	{
		return $this->hasMany('App\Models\Facultades');
	}

}
