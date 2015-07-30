@section('welcome')
<a class="navbar-brand" href="/alumno">Gestión de Salas UTEM</a>
@stop

                   
 <table class="table table-striped">     
      <tr> 
         <th>       
            <h2><i class="glyphicon glyphicon-pencil" aria-hidden="true"></i><b> Bienvenido Alumno </b></h2>                
         </th>
      
          <th>     
<<<<<<< HEAD
            {!! Form::open(['action' => ['Administrador\PerfilController@get_cambioPerfil'], 'method' => 'GET', 'class' => 'pull-right']) !!}
=======
            {!! Form::open(['action' => ['Administrador\PerfilController@get_pichula'], 'method' => 'GET', 'class' => 'pull-right']) !!}
>>>>>>> d54c8fa948ab220500fe59fd7e40157631c5a416
              <div class="form-group" style="margin-top: 20px">
            {!! Form::select('perfil', $var,null,['class' => 'form-control']) !!}
              </div>      
          </th>
          <th>
            <div class="form-group" style="margin-top: 20px">
              <button type="submit" class="btn btn-primary">Aceptar</button>
              {!! Form::close() !!}
            </div>
         </th>
      </tr>
  </table>      



<div class="col-sm-3">
                                          
  <div class="sidebar-nav navbar-collapse" style="margin-top: 15px">

      <ul class="list-group" id="side-menu">
          <a class="list-group-item active"><i class="glyphicon glyphicon-list" aria-hidden="true"></i> Menú Alumno</a>

            <li class="list-group-item"> <a href="{{URL::to('/alumno/horario')}}"><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i>Horario</a></li>
            <li class="list-group-item"><a href="{{URL::to('/alumno/consulta')}}"><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i>Consultar</a></li>  
          
       
      </ul>
      
    </div>

</div>