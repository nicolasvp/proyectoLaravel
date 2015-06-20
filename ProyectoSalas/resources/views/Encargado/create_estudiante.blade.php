@extends('layouts/master')

@section('welcome')

Gestión de salas - UTEM

@stop


@section('sideBar')



<div class="panel panel-default" style="margin-top: 40px;">
                        <div class="panel-heading">
                            

                            <h2><i class="glyphicon glyphicon-edit" aria-hidden="true"></i><b> Bienvenido Encargado </b></h2> 

                        </div>
                        <div class="panel-body">                  
                  
                        <div class="row">
                          <div class="col-sm-3">
                                          
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                    
                        <li>
                       <a class="list-group-item active"><i class="glyphicon glyphicon-list" aria-hidden="true"></i> Menú Encargado</a>
</li>

            <li> <a href="{{URL::to('/Encargado/cursos')}}">Asignar Salas</a></li>
            <li><a href="{{URL::to('/Encargado/campus')}}">Modificar Salas</a></li> 
            <li><a href="{{URL::to('/Encargado/ingreso')}}">Ingresar Datos</a></li>             

</li>

</div>

</div>


         <div class="col-sm-9" >
   <p> <h2>Ingrese los datos del estudiante</h2></p>
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">
       <div class="form-group">
  
      {!! Form::open(['action' => ['EncargadoController@post_storeEstudiante'], 'method' => 'POST']) !!}

      <div class="form-group">
       {!! Form::label('carrera_id', 'Carrera') !!}
       {!! Form::select('carrera_id', (['0' => '-- Seleccionar una carrera --'] +$carreras), null, ['class' => 'form-control'])!!}
      </div>


      <div class="form-group">
        {!! Form::label('rut', 'RUT') !!}
       {!! Form::text('rut', '',['class' => 'form-control', 'placeholder' => 'Ingresa RUT']) !!}
      </div>

      <div class="form-group">
        {!! Form::label('nombres', 'Nombres') !!}
       {!! Form::text('nombres', '',['class' => 'form-control', 'placeholder' => 'Ingresa nombres']) !!}
      </div>

      <div class="form-group">
        {!! Form::label('apellidos', 'Apellidos') !!}
       {!! Form::text('apellidos', '',['class' => 'form-control', 'placeholder' => 'Ingresa apellidos']) !!}
      </div>

      <div class="form-group">
       {!! Form::label('email', 'Email') !!}
       {!! Form::text('email', '',['class' => 'form-control', 'placeholder' => 'Ingresa email']) !!}
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