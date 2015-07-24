<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use App\Models\Rol_usuario;

class IsAdmin {

	private $auth;

	public function __construct(Guard $auth)
	{
		$this->auth = $auth;
	}

	public function handle($request, Closure $next)
	{
		$rut = $this->auth->user()->rut;

		            
        $var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=',$rut)
                            ->select('roles.nombre')
                            ->get();  

		$admin = false;

		foreach($var as $v)
		{
			if($v->nombre == 'administrador')
			{
				$admin = true;
			}
		
		}
		

		if($admin != true){

		$this->auth->logout();

			if ($request->ajax())
			{
				return response('Unauthorized.', 401);
			}
			else
			{
				return redirect()->to('/login');
			}
		
		}


		return $next($request);

	}
}