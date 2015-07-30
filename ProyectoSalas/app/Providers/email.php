<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class email extends ServiceProvider {

	
	public function boot()
	{
        \Validator::extend('valid_email', function($attribute, $value, $parameters)
           {
            return preg_match('/^[a-zA-Z0-9\._-]+@[a-zA-Z0-9-]{2,}[.][a-zA-Z]{2,4}$/', $value);
        });
	}
	public function register()
	{
		///
	}

}