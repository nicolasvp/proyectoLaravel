<?php namespace App\Models;


use Illuminate\Database\Eloquent\Model;



class Facultades extends Model  {

	
	protected $table = 'facultades';


	protected $fillable = ['nombre', 'campus_id','descripcion'];

	public function campus()
	{
		return $this->belongsTo('App\Models\Campus');
	}

}
