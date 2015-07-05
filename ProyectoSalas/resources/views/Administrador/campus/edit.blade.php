@extends('layouts/master')



@section('sideBar')


      
   @include('Administrador/menu')
       


<div class="col-sm-9" >
  <p> <h2>Editar los datos del campus: {{ $campusEditable->nombre }}</h2></p>
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">
       <div class="form-group">
  
      {!! Form::model($campusEditable, ['action' => ['AdministradorController@put_update', $campusEditable], 'method' => 'PUT']) !!}

      <div class="form-group">
       {!! Form::label('nombre', 'Nombre') !!}
       {!! Form::text('nombre', null,['class' => 'form-control', 'placeholder' => 'Ingresa nombre']) !!}
         
      </div>

      <div class="form-group">
        {!! Form::label('direccion', 'Dirección') !!}
       {!! Form::text('direccion', null,['class' => 'form-control', 'placeholder' => 'Ingresa dirección']) !!}
      </div>

      <div class="form-group">
        {!! Form::label('latitud', 'Latitud') !!}
       {!! Form::text('latitud', null,['class' => 'form-control', 'placeholder' => 'Ingresa latitud']) !!}
      </div>

      <div class="form-group">
        {!! Form::label('longitud', 'Longitud') !!}
       {!! Form::text('longitud', null,['class' => 'form-control', 'placeholder' => 'Ingresa longitud']) !!}
      </div>

      <div class="form-group">
        {!! Form::label('descripcion', 'Descripción') !!}
       {!! Form::text('descripcion', null,['class' => 'form-control', 'placeholder' => 'Ingresa descripción']) !!}
      </div>

      <div class="form-group">
        {!! Form::label('rut_encargado', 'Rut Encargado') !!}
       {!! Form::text('rut_encargado', null,['class' => 'form-control', 'placeholder' => 'Ingresa rut']) !!}
      </div>

        {!! Form::hidden('id', $id)!!}

      <div align=center><button type="submit" class="btn btn-info">Actualizar campus</button></div>

      {!! Form::close() !!}

  
  </div>

                    
</div>

</div>


</div>

                    
</div>


      </div>
    </div>

@stop