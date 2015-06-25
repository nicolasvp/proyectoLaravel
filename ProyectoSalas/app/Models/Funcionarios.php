<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;


class Funcionarios extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'funcionarios';

	


	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
		protected $fillable = ['departamento_id','rut','nombres','apellidos'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

}
