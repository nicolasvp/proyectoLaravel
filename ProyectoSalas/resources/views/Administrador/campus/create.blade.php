@extends('layouts/master')


@section('sideBar')


<div class="panel panel-default" style="margin-top: 40px;">

    @include('Administrador/menu')
       
  <div class="panel-body">                  
                  
   <div class="row">

         <div class="col-sm-9" >

           <p>
                         {!! Form::open(['action' => 'Administrador\CampusController@get_upload', 'method' => 'GET']) !!}
   
                          <button type="submit" class="btn btn-info pull-right">Subir archivo</button>

                         {!! Form::close() !!}
         </p>

   <p> <h2>Ingrese los datos para crear un campus</h2></p>
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">

@include('Administrador/messages')

       <div class="form-group">
  
      {!! Form::open(['action' => ['Administrador\CampusController@post_store'], 'method' => 'POST']) !!}

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
       {!! Form::textarea('descripcion', '',['class' => 'form-control', 'placeholder' => 'Ingresa descripción']) !!}
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
      </div>
   
@stop