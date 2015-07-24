@extends('layouts/master')



@section('sideBar')


 <div class="panel panel-default" style="margin-top: 40px;">            
             @include('Administrador/menu')

  <div class="panel-body">                  
                  
   <div class="row">

         <div class="col-sm-9" >
                     <p>
                         {!! Form::open(['action' => 'Administrador\DepartamentoController@get_facultades', 'method' => 'GET']) !!}
   
                          <button type="submit" class="btn btn-info pull-right">Subir archivo</button>

                         {!! Form::close() !!}
         </p>
         
   <p> <h2>Ingrese los datos para el departamento</h2></p>
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">

    @include('Administrador/messages')
       <div class="form-group">
  
      {!! Form::open(['action' => ['Administrador\DepartamentoController@post_store'], 'method' => 'POST']) !!}


      <div class="form-group">
       {!! Form::label('facultad_id', 'Facultad') !!}
       {!! Form::select('facultad_id', (['0' => '-- Seleccionar una facultad --'] +$facultades), null, ['class' => 'form-control'])!!}
      </div>

      <div class="form-group">
        {!! Form::label('nombre', 'Nombre') !!}
       {!! Form::text('nombre', null,['class' => 'form-control', 'placeholder' => 'Ingresa nombre']) !!}
      </div>

        <div class="form-group">
        {!! Form::label('descripcion', 'Descripción') !!}
       {!! Form::textarea('descripcion', null,['class' => 'form-control', 'placeholder' => 'Ingresa descripción']) !!}
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
    </div>
@stop