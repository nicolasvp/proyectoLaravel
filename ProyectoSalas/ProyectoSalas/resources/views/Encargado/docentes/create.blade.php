@extends('layouts/master')



@section('sideBar')

      
            @include('Encargado/top')
       


         <div class="col-sm-9" >
                      <p>
                         {!! Form::open(['action' => 'Encargado\DocenteController@get_departamentos', 'method' => 'GET']) !!}
   
                          <button type="submit" class="btn btn-info pull-right">Subir archivo</button>

                         {!! Form::close() !!}
                       </p>

   <p> <h2>Ingrese los datos para el docente</h2></p>
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">

    @include('Encargado/messages')

       <div class="form-group">
  
      {!! Form::open(['action' => ['Encargado\DocenteController@post_store'], 'method' => 'POST']) !!}


      <div class="form-group">
       {!! Form::label('departamento_id', 'Departamento') !!}
       {!! Form::select('departamento', (['0' => '-- Seleccionar un departamento --'] +$departamentos), null, ['class' => 'form-control'])!!}
      </div>


      <div class="form-group">
       {!! Form::label('rut', 'Rut') !!}
       {!! Form::text('rut', null,['class' => 'form-control', 'placeholder' => 'Ingresa rut']) !!}
         
      </div>

      <div class="form-group">
        {!! Form::label('nombres', 'Nombres') !!}
       {!! Form::text('nombres', null,['class' => 'form-control', 'placeholder' => 'Ingresa nombres']) !!}
      </div>

        <div class="form-group">
        {!! Form::label('apellidos', 'Apellidos') !!}
       {!! Form::text('apellidos', null,['class' => 'form-control', 'placeholder' => 'Ingresa apellidos']) !!}
      </div>


      <div align=center><button type="submit" class="btn btn-info">Aceptar</button></div>

      {!! Form::close() !!}
     
  </div>

                    
</div>
</div>
</div>

                    
</div>


      </div>
    </div>

@stop