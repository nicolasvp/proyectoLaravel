@extends('layouts/master')


@section('sideBar')



    @include('Administrador/menu')
       


         <div class="col-sm-9" >
   <p> <h2>Ingrese los datos para crear un campus</h2></p>
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">
       <div class="form-group">
  
      {!! Form::open(['action' => ['AdministradorController@post_store'], 'method' => 'POST']) !!}

      <div class="form-group">
       {!! Form::label('nombre', 'Nombre') !!}
       {!! Form::text('nombre', '',['class' => 'form-control', 'placeholder' => 'Ingresa nombre']) !!}
         
      </div>

      <div class="form-group">
        {!! Form::label('direccion', 'Dirección') !!}
       {!! Form::text('direccion', '',['class' => 'form-control', 'placeholder' => 'Ingresa dirección']) !!}
      </div>

      <div class="form-group">
        {!! Form::label('latitud', 'Latitud') !!}
       {!! Form::text('latitud', '',['class' => 'form-control', 'placeholder' => 'Ingresa latitud']) !!}
      </div>

      <div class="form-group">
        {!! Form::label('longitud', 'Longitud') !!}
       {!! Form::text('longitud', '',['class' => 'form-control', 'placeholder' => 'Ingresa longitud']) !!}
      </div>

      <div class="form-group">
        {!! Form::label('descripcion', 'Descripción') !!}
       {!! Form::text('descripcion', '',['class' => 'form-control', 'placeholder' => 'Ingresa descripción']) !!}
      </div>

      <div class="form-group">
        {!! Form::label('rut_encargado', 'Rut Encargado') !!}
       {!! Form::text('rut_encargado', '',['class' => 'form-control', 'placeholder' => 'Ingresa rut']) !!}
      </div>
      
      <div align=center><button type="submit" class="btn btn-primary">Crear campus</button></div>

      {!! Form::close() !!}
     
  </div>

                    
</div>
</div>
</div>

                    
</div>


      </div>
    </div>

@stop