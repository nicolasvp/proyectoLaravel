@section('welcome')
<a class="navbar-brand" href="/docente">Gestión de Salas UTEM</a>
@stop

    <table class="table table-striped">     
      <tr> 
         <th>       
           <h2><i class="glyphicon glyphicon-pencil" aria-hidden="true"></i><b> Bienvenido Docente </b></h2>                 
         </th>
      
          <th>     
            {!! Form::open(['action' => ['Administrador\PerfilController@get_pichula'], 'method' => 'GET', 'class' => 'pull-right']) !!}
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
</div>
