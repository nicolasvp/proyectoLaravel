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
            return preg_match('/^([-k 0-9 .-])+$/i', $value);
        });
	}

	
	public function register()
	{
		//
	}

}
