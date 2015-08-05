@extends('layouts/master')



@section('sideBar')

<div class="panel panel-default" style="margin-top: 40px;">
      
   @include('Administrador/menu')
       
  <div class="panel-body">                  
                  
   <div class="row">

<div class="col-sm-9" >
  <p> <h2>Editar los datos del campus: {{ $campusEditable->nombre }}</h2></p>
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">

    @include('Administrador/messages')
    
       <div class="form-group">
  
      {!! Form::model($campusEditable, ['action' => ['Administrador\CampusController@put_update', $campusEditable], 'method' => 'PUT']) !!}

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
       {!! Form::textarea('descripcion', null,['class' => 'form-control', 'placeholder' => 'Ingresa descripción']) !!}
      </div>


      <div class="form-group">
        {!! Form::label('rut_encargado', 'Rut Encargado') !!}
       {!! Form::select('rut_encargado', (['0' => '-- Seleccionar una encargado --'] +$encargados), null, ['class' => 'form-control'])!!}
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
      </div>

@stop