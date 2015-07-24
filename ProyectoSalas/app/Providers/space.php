<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Providers\Validator;

class space extends ServiceProvider {

	
	public function boot()
	{
		\Validator::extend('space', function($attribute, $value, $parameters)
           {
            return preg_match('/^([-a-z - _-ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîï
    	      ðñòóôõöùúûüýøþÿÐdŒ-\s])+$/i', $value);
        });
	}

	
	public function register()
	{
	   

	}

}