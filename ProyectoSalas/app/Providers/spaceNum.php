<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Providers\Validator;

class spaceNum extends ServiceProvider {

	
	public function boot()
	{
		\Validator::extend('spaceNum', function($attribute, $value, $parameters)
           {
            return preg_match('/^([-a-z 0-9 -_-ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîï
    	      ðñòóôõöùúûüýøþÿÐdŒ-\s])+$/i', $value);
        });
	}

	
	public function register()
	{
	   //

	}

}