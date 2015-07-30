<?php namespace App\Models;


use Illuminate\Database\Eloquent\Model;


class Campus extends Model  {


	protected $table = 'campus';

	protected $fillable = ['nombre', 'direccion', 'latitud', 'longitud', 'rut_encargado' , 'descripcion'];


	public function facultades()
	{
		return $this->hasMany('App\Models\Facultades');
	}

}
