<?php namespace App\Http\Controllers;


use Input;
use Auth;

class loginController extends Controller {


	protected $layout='layouts.master';



	public function getIndex()
	{

		return view ('Login.login');
	}




	public function postIndex()
	{
       
        $userdata = array(
          
            'rut' => Input::get('rut'),
            'password' => Input::get('password')
        );

        $rut = \App\RutUtils::rut($userdata['rut']);
    
        $rules = array(
            'rut' => 'Required',
            'password' => 'Required'
        );
   
        if (Auth::attempt($userdata)) {
        	
            $user = \App\Usuario::whereRut($rut)->first();
               if($user->tipousuario()=='alumno')
                   return view ('Alumno.indexAlumno');
               else
                    return view ("Docente.indexDocente");
        }
        else
        {
            dd("MALO");
            return Redirect::to('login')->with('login_errors', true);
        }

	}


}
