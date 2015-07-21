<?php namespace App\Models;


use Illuminate\Database\Eloquent\Model;



class Funcionario extends Model {


	protected $table = 'funcionarios';


	protected $fillable = ['departamento_id','rut','nombres','apellidos'];



}
