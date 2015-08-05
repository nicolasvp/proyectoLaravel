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

           		$verificar_rut = \App\RutUtils::isRut($value);
           		
				if($verificar_rut)
				{
					return $value ;

				}
				
					return false;
           
        });
	}

	
	public function register()
	{
		//
	}

}
