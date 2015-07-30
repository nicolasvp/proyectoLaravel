
@section('welcome')
<a class="navbar-brand" href="/administrador">Gestión de Salas UTEM</a>
@stop
    <table class="table table-striped">     
      <tr> 
         <th>       
           <h2><i class="glyphicon glyphicon-user" aria-hidden="true"></i><b> Bienvenido Administrador </b></h2>                
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
                    
                        
                      <a class="list-group-item active"><i class="glyphicon glyphicon-list" aria-hidden="true"></i> Menú Administrador</a>

            <li class="list-group-item"> <a href="{{URL::to('/administrador/campus')}}"><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i>Campus</a></li>             
            <li class="list-group-item"><a href="{{URL::to('/administrador/facultades')}}"><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i>Facultades</a></li>
            <li class="list-group-item"><a href="{{URL::to('/administrador/departamentos')}}"><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i>Departamentos</a></li>
            <li class="list-group-item"><a href="{{URL::to('/administrador/escuelas')}}"><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i>Escuelas</a></li>
            <li class="list-group-item"><a href="{{URL::to('/administrador/carreras')}}"><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i>Carreras</a></li>
            <li class="list-group-item"><a href="{{URL::to('/administrador/estudiantes')}}"><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i>Estudiantes</a></li>
            <li class="list-group-item"><a href="{{URL::to('/administrador/docentes')}}"><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i>Docentes</a></li>
            <li class="list-group-item"><a href="{{URL::to('/administrador/funcionarios')}}"><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i>Funcionarios</a></li>
            <li class="list-group-item"><a href="{{URL::to('/administrador/asignaturas')}}"><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i>Asignaturas</a></li>
            <li class="list-group-item"><a href="{{URL::to('/administrador/cursos')}}"><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i>Cursos</a></li>
            <li class="list-group-item"><a href="{{URL::to('/administrador/salas')}}"><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i>Salas</a></li>
            <li class="list-group-item"><a href="{{URL::to('/administrador/roles')}}"><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i>Roles</a></li>
            <li class="list-group-item"><a href="{{URL::to('/administrador/usuarios')}}"><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i>Usuarios</a></li>
            <li class="list-group-item"><a href="{{URL::to('/administrador/periodos')}}"><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i>Períodos</a></li>                      
       
      </ul>
      
    </div>

</div>