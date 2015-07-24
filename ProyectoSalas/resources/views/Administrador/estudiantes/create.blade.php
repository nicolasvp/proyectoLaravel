@extends('layouts/master')



@section('sideBar')


    
<div class="panel panel-default" style="margin-top: 40px;">  
             @include('Administrador/menu')
       
  <div class="panel-body">                  
                  
   <div class="row">
         <div class="col-sm-9" >
                                <p>
                         {!! Form::open(['action' => 'Administrador\EstudianteController@get_carrera', 'method' => 'GET']) !!}
   
                          <button type="submit" class="btn btn-info pull-right">Subir archivo</button>

                         {!! Form::close() !!}
         </p>

   <p> <h2>Ingrese los datos para el estudiante</h2></p>
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">

    @include('Administrador/messages')
    
       <div class="form-group">
  
      {!! Form::open(['action' => ['Administrador\EstudianteController@post_store'], 'method' => 'POST']) !!}


      <div class="form-group">
       {!! Form::label('carrera_id', 'Carrera') !!}
       {!! Form::select('carrera', (['0' => '-- Seleccionar una carrera --'] +$carreras), null, ['class' => 'form-control'])!!}
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


      <div align=center><button type="submit" class="btn btn-success">Aceptar</button></div>

      {!! Form::close() !!}
     
  </div>

                    
</div>
</div>
</div>

  </div>
                  
</div>


      </div>
    </div>

@stop