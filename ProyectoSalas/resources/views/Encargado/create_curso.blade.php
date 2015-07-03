@extends('layouts/master')

@section('welcome')

Gestión de salas - UTEM

@stop


@section('sideBar')



@include('Encargado/menu');



         <div class="col-sm-9" >
   <p> <h2>Ingrese los datos para el curso</h2></p>
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">
       <div class="form-group">
  
      {!! Form::open(['action' => ['EncargadoController@post_store'], 'method' => 'POST']) !!}

      <div class="form-group">
       {!! Form::label('asignatura_id', 'Asignatura') !!}
       {!! Form::select('asignatura_id', (['0' => '-- Seleccionar una asignatura --'] +$asignaturas), null, ['class' => 'form-control'])!!}
      </div>


      <div class="form-group">
        {!! Form::label('docente_id', 'Docente') !!}
       {!! Form::select('docente_id', (['0' => '-- Seleccionar un docente --'] +  $docentes), null, ['class' => 'form-control'])!!}
      </div>

      <div class="form-group">
        {!! Form::label('semestre', 'Semestre') !!}
       {!! Form::text('semestre', '',['class' => 'form-control', 'placeholder' => 'Ingresa semestre']) !!}
      </div>

      <div class="form-group">
        {!! Form::label('anio', 'Anio') !!}
       {!! Form::text('anio', '',['class' => 'form-control', 'placeholder' => 'Ingresa año']) !!}
      </div>

      <div class="form-group">
        {!! Form::label('seccion', 'Sección') !!}
       {!! Form::text('seccion', '',['class' => 'form-control', 'placeholder' => 'Ingresa sección']) !!}
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