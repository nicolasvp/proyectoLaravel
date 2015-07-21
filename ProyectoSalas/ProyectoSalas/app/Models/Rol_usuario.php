<?php namespace App\Models;


use Illuminate\Database\Eloquent\Model;


class Rol_usuario extends Model {


	protected $table = 'roles_usuarios';


	protected $fillable = ['rut', 'rol_id'];

}
