<?php namespace App\Http\Controllers\Encargado;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Rol_usuario;



class EncargadoController extends Controller {


	protected $layout='layouts.master';


	public function getIndex()
	{

		$var = Rol_usuario::join('roles','roles_usuarios.rol_id','=','roles.id')
                            ->where('roles_usuarios.rut','=', \Auth::user()->rut)
                            ->select('roles.*','roles_usuarios.*')
                            ->lists('roles.nombre','roles.nombre'); 

		return view('Encargado/indexEncargado',compact('var'));

	}




}
