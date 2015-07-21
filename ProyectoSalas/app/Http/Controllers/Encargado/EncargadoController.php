<?php namespace App\Http\Controllers\Encargado;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;




class EncargadoController extends Controller {


	protected $layout='layouts.master';


	public function getIndex()
	{

		return view('Encargado/indexEncargado');

	}




}
