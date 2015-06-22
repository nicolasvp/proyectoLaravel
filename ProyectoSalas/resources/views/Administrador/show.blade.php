@extends('layouts/master')

@section('welcome')

 Gestión de salas - UTEM


@stop


@section('sideBar')



<div class="panel panel-default" style="margin-top: 40px;">
                        <div class="panel-heading">
                            

                            <h2><i class="glyphicon glyphicon-user" aria-hidden="true"></i><b> Bienvenido Administrador </b></h2> 

                        </div>
                        <div class="panel-body">                  
                  
                        <div class="row">
                          <div class="col-sm-3">
                                          
                <div class="sidebar-nav navbar-collapse">

                    <ul class="list-group" id="side-menu">
                    
                        
                      <a class="list-group-item active"><i class="glyphicon glyphicon-list" aria-hidden="true"></i> Menú Administrador</a>


            <li class="list-group-item"> <a href="{{URL::to('/Administrador/create')}}"><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i> Crear Campus</a></li>
            <li class="list-group-item"><a href="{{URL::to('/Administrador/')}}"><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i>Modificar Campus</a></li>
            <li class="list-group-item"><a href="{{URL::to('/Administrador/search')}}"><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i>Asignar Perfil</a></li>               
            <li class="list-group-item"><a href="{{URL::to('/Administrador/campus')}}"><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i>Archivar Campus</a></li>
            <li class="list-group-item"><a href="{{URL::to('/Administrador/filed')}}"><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i>Campus Archivados</a></li>
            <li class="list-group-item"><a href="{{URL::to('/Administrador/')}}"><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i>Salas</a></li>
            <li class="list-group-item"><a href="{{URL::to('/Administrador/carreras')}}"><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i>Cursos</a></li>
            <li class="list-group-item"><a href="{{URL::to('/Administrador/carrera')}}"><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i>Asignaturas</a></li>
            <li class="list-group-item"><a href="{{URL::to('/Administrador/')}}"><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i>Estudiantes</a></li>
            <li class="list-group-item"><a href="{{URL::to('/Administrador/')}}"><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i>Docentes</a></li>
            <li class="list-group-item"><a href="{{URL::to('/Administrador/')}}"><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i>Carreras</a></li>
            <li class="list-group-item"><a href="{{URL::to('/Administrador/')}}"><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i>Departamentos</a></li>
            <li class="list-group-item"><a href="{{URL::to('/Administrador/')}}"><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i>Escuelas</a></li>
            <li class="list-group-item"><a href="{{URL::to('/Administrador/')}}"><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i>Facultades</a></li>
            <li class="list-group-item"><a href="{{URL::to('/Administrador/')}}"><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i>Funcionarios</a></li>
            <li class="list-group-item"><a href="{{URL::to('/Administrador/')}}"><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i>Periodos</a></li>
            <li class="list-group-item"><a href="{{URL::to('/Administrador/')}}"><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i>Roles</a></li>  
       
</li>
</ul>
</div>

</div>







<div class="col-sm-9" >
  <p> <h2>Perfiles del usuario </h2></p>
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">


       <div class="form-group">

        <table class="table table-striped">
            <tr> 
              <th>#</th>
              <th>Rut</th>
              <th>Rol</th>
              <th>Acción</th>
              
            </tr>

            @foreach($datos_usuario as $users)
            
            <tr>
               <td>{{ $users->id}}</td>
               <td>{{ $users->rut}}</td>
               <td>{{ $users->nombre}}</td>
                <td> 
      {!! Form::open(['action' => ['AdministradorController@delete_rol'], 'method' => 'DELETE']) !!}
      {!! Form::hidden('id', $users->id)!!}
       <button type="submit" onclick="return confirm('¿Seguro que desea eliminar?')" class="btn btn-danger btn-sm">Eliminar</button>
      {!! Form::close() !!}

               </td>
            </tr>
             @endforeach

          </table>
  

  </div>
                    
</div>
</div>
<p> <h2>Asignar perfil</h2></p>
<div class="panel panel-default">
    <div class="panel-body">
      @if(Session::has('message'))

          <p class="alert alert-sucess"><b>{{ Session::get('message') }}</b></p>


      @endif
       <table class="table table-striped">


     <div class="form-group">
   {!! Form::open(['action' => 'AdministradorController@post_profile']) !!}

    <div class="form-group">
    {!! Form::hidden('rut', $rut)!!}
    </div>

    <div class="form-group">
   {!! Form::select('rol_asig', (['0' => 'Selecciona un Perfil'] + $rol_usuario), null, ['class' => 'form-control']) !!}
    </div>

      <div align="center"<th><button type="submit" onclick="return confirm('¿Seguro que desea asignar este perfil?')" class="btn btn-primary ">Asignar perfil</button></th></div>
      {!! Form::close() !!}

      </div>

      </table>

    </div>
</div>


</div>

                    
</div>


      </div>
    </div>

@stop