<?php namespace App\Http\Controllers\Administrador;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;





class AdministradorController extends Controller {


	protected $layout='layouts.master';


	public function getIndex()
	{

		return view('Administrador/indexAdministrador');
	}


}
