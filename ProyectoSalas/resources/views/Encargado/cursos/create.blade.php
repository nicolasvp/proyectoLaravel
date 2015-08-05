@extends('layouts/master')


@section('sideBar')



<div class="panel panel-default" style="margin-top: 40px;">
           
           @include('Encargado/top')
             
  <div class="panel-body">                  
                  
   <div class="row">
             
         <div class="col-sm-9" >

         <p>
              {!! Form::open(['action' => 'Encargado\CursoController@get_upload', 'method' => 'GET']) !!}
              {!! Form::hidden('departamento', $departamento)!!}
              <button type="submit" class="btn btn-info pull-right">Subir archivo</button>

              {!! Form::close() !!}
         </p>


   <p> <h2>Ingrese los datos para el curso</h2></p>
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">

        @include('Encargado/messages')
        
       <div class="form-group">
  
      {!! Form::open(['action' => ['Encargado\CursoController@post_store'], 'method' => 'POST']) !!}

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


      </div>
 

@stop