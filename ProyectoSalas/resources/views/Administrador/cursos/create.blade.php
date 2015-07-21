@extends('layouts/master')


@section('sideBar')



           
           @include('Administrador/menu')
       


      
         <div class="col-sm-9" >
   <p> <h2>Ingrese los datos para el curso</h2></p>
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">

    @include('Administrador/messages')
       <div class="form-group">
  
      {!! Form::open(['action' => ['Administrador\CursoController@post_store'], 'method' => 'POST']) !!}

      <div class="form-group">
       {!! Form::label('asignatura', 'Asignatura') !!}
       {!! Form::select('asignatura', (['0' => '-- Seleccionar una asignatura --'] +$asignaturas), null, ['class' => 'form-control'])!!}
      </div>


      <div class="form-group">
        {!! Form::label('docente', 'Docente') !!}
       {!! Form::select('docente', (['0' => '-- Seleccionar un docente --'] +  $docentes), null, ['class' => 'form-control'])!!}
      </div>

      <div class="form-group">
        {!! Form::label('semestre', 'Semestre') !!}
       {!! Form::text('semestre', '',['class' => 'form-control', 'placeholder' => 'Ingresa semestre']) !!}
      </div>

      <div class="form-group">
        {!! Form::label('año', 'Año') !!}
       {!! Form::text('año', '',['class' => 'form-control', 'placeholder' => 'Ingresa año']) !!}
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