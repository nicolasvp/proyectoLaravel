<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Usuario;
use App\Models\Rol_usuario;
use Illuminate\Http\Request;
use \Illuminate\Contracts\Auth\Guard as Auth;


class loginController extends Controller
{
    /**
     * The Guard implementation.
     *
     * @var \Illuminate\Contracts\Auth\Guard
     */
    protected $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    public function getIndex()
    {
        return view('login/login');
    }

    public function post_index(Request $request)
    {

        $credenciales = $request->only(['rut', 'password']);
        $rules = [ // Reglas de validacion TODO: validar rut
            'rut' => 'required',
            'password' => 'required'
        ];
   
        $this->validate($request, $rules); // Valida que se envien ambos parametros

        if ($this->auth->attempt($credenciales, $request->has('remember')))
        { // Login exitoso
<<<<<<< HEAD
        
=======
            
>>>>>>> d54c8fa948ab220500fe59fd7e40157631c5a416
            $rut = $this->auth->user()->rut;
            
            $var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=',$rut)
                            ->select('roles.nombre')
                            ->get();         
<<<<<<< HEAD

            if($var->first()->nombre == 'administrador')
            {
                return redirect()->action('Administrador\AdministradorController@getIndex');
            }
            if($var->first()->nombre == 'encargado')
            {
                return redirect()->action('Encargado\EncargadoController@getIndex');
            }
            if($var->first()->nombre == 'estudiante')
            {

=======

            if($var->first()->nombre == 'administrador')
            {
                return redirect()->action('Administrador\AdministradorController@getIndex');
            }
            if($var->first()->nombre == 'encargado')
            {
                return redirect()->action('Encargado\EncargadoController@getIndex');
            }
            if($var->first()->nombre == 'estudiante')
            {

>>>>>>> d54c8fa948ab220500fe59fd7e40157631c5a416
                return redirect()->action('AlumnoController@getIndex');
            }
            if($var->first()->nombre == 'docente')
            {
                return redirect()->action('DocenteController@getIndex');
            }

<<<<<<< HEAD
           // return redirect()->action('Administrador\AdministradorController@getIndex');
=======
            //return redirect()->action('Administrador\AdministradorController@getIndex');
>>>>>>> d54c8fa948ab220500fe59fd7e40157631c5a416
        }
    
        
        return redirect()->action('loginController@getIndex')
                ->with('login_errors', true);
<<<<<<< HEAD
       
=======
        
>>>>>>> d54c8fa948ab220500fe59fd7e40157631c5a416
        //    ->withInput($request->only(['rut', 'remember']))
          //  ->withErrors(['rut' => 'Sus credenciales no son válidas, intente nuevamente!']);
    }

    public function getLogout()
    {
        $this->auth->logout();

        return redirect()->action('loginController@getIndex')
            ->with('message', 'Ha salido correctamente');
    }
}