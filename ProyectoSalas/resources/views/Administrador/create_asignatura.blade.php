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
   <p> <h2>Ingrese los datos para la asignatura</h2></p>
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">
       <div class="form-group">
  
      {!! Form::open(['action' => ['AdministradorController@post_storeAsignatura'], 'method' => 'POST']) !!}

      <div class="form-group">
       {!! Form::label('departamento_id', 'Departamento') !!}
       {!! Form::select('departamento_id', (['0' => '-- Seleccionar un departamento --'] +$departamentos), null, ['class' => 'form-control'])!!}
      </div>


      <div class="form-group">
        {!! Form::label('codigo', 'Código') !!}
       {!! Form::text('codigo', '',['class' => 'form-control', 'placeholder' => 'Ingresa código']) !!}
      </div>

      <div class="form-group">
        {!! Form::label('nombre', 'Nombre') !!}
       {!! Form::text('nombre', '',['class' => 'form-control', 'placeholder' => 'Ingresa nombre']) !!}
      </div>

      <div class="form-group">
        {!! Form::label('descripcion', 'Descripción') !!}
       {!! Form::text('descripcion', '',['class' => 'form-control', 'placeholder' => 'Ingresa descripción']) !!}
      </div>



      <div align=center><button type="submit" class="btn btn-primary">Aceptar</button></div>

      {!! Form::close() !!}
     
  </div>

                    
</div>
</div>
</div>

                    
</div>


      </div>
    </div>

@stop