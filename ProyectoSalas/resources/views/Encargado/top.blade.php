@section('welcome')
<a class="navbar-brand" href="/encargado">Gestión de Salas UTEM</a>
@stop

    <table class="table table-striped">     
      <tr> 
         <th>       
            <h2><i class="glyphicon glyphicon-edit" aria-hidden="true"></i><b> Bienvenido Encargado </b></h2>                
         </th>
      
          <th>     
            {!! Form::open(['action' => ['Administrador\PerfilController@get_cambioPerfil'], 'method' => 'GET', 'class' => 'pull-right']) !!}
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
                    
                        
                       <a class="list-group-item active"><i class="glyphicon glyphicon-list" aria-hidden="true"></i> Menú Encargado</a>

            <li class="list-group-item"> <a href="{{URL::to('/encargado/salas')}}"><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i>Salas</a></li>
            <li class="list-group-item"> <a href="{{URL::to('/encargado/cursos')}}"><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i>Cursos</a></li>       
            <li class="list-group-item"><a href="{{URL::to('/encargado/asignaturas')}}"><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i>Asignaturas</a></li> 
            <li class="list-group-item"><a href="{{URL::to('/encargado/estudiantes')}}"><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i>Estudiantes</a></li> 
            <li class="list-group-item"><a href="{{URL::to('/encargado/docentes')}}"><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i>Docentes</a></li>  
            <li class="list-group-item"><a href="{{URL::to('/encargado/horarios')}}"><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i>Lista de horarios</a></li>
      </ul>
      
    </div>

</div>