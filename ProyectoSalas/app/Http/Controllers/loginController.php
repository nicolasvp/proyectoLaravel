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
        
            $rut = $this->auth->user()->rut;
            
            $var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=',$rut)
                            ->select('roles.nombre')
                            ->get();         

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
                return redirect()->action('Estudiante\EstudianteController@getIndex');
            }
            if($var->first()->nombre == 'docente')
            {
                return redirect()->action('Docente\DocenteController@getIndex');
            }

           // return redirect()->action('Administrador\AdministradorController@getIndex');
        }
    
        
        return redirect()->action('loginController@getIndex')
                ->with('login_errors', true);
       
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