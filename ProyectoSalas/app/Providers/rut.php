<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Providers\Validator;

class rut extends ServiceProvider {

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		\Validator::extend('rut', function($attribute, $value, $parameters)
           {
<<<<<<< HEAD

           		$verificar_rut = \App\RutUtils::isRut($value);
           		
				if($verificar_rut)
				{
					return $value ;

				}
				
					return false;
           
=======
            return preg_match('/^([-k 0-9 .-])+$/i', $value);
>>>>>>> d54c8fa948ab220500fe59fd7e40157631c5a416
        });
	}

	
	public function register()
	{
		//
	}

}
