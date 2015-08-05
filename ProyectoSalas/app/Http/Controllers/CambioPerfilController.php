<?php namespace App\Http\Controllers;
use App\Http\Requests;
use Illuminate\Http\Request;


class CambioPerfilController extends Controller {


	public function getIndex()
	{
		return redirect()->to('/login');
	}
	public function get_cambioPerfil(Request $request)
	{
	

            if($request->get('perfil') == 'administrador')
            {
                return redirect()->action('Administrador\AdministradorController@getIndex');
            }
            if($request->get('perfil') == 'encargado')
            {
                return redirect()->action('Encargado\EncargadoController@getIndex');
            }
            if($request->get('perfil') == 'estudiante')
            {
                return redirect()->action('Estudiante\EstudianteController@getIndex');
            }
            if($request->get('perfil') == 'docente')
            {
                return redirect()->action('Docente\DocenteController@getIndex');
            }

		return redirect()->action('CambioPerfilController@getIndex');

	}
	

}
