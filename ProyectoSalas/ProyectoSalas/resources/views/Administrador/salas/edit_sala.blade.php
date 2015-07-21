@extends('layouts/master')

@section('sideBar')


        
           @include('Administrador/menu')


   <div class="col-sm-9" >
   <p> <h2>Modificar la sala</h2></p>

      @if(Session::has('message'))

         
          <div class="alert alert-dismissible alert-success">
           <strong>{{ Session::get('message') }}</strong>
          </div>

      @endif
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">
       <div class="form-group">
  


   
      {!! Form::model($datos_sala, ['action' => ['Administrador\SalaController@put_updateSala', $datos_sala], 'method' => 'PUT']) !!}

      <div class="form-group">
       {!! Form::label('nombre', 'Nombre') !!}
       {!! Form::text('nombre', null,['class' => 'form-control', 'placeholder' => 'Ingresa nombre']) !!}
      </div>

      <div class="form-group">
        {!! Form::label('capacidad', 'Capacidad') !!}
       {!! Form::text('capacidad', null,['class' => 'form-control', 'placeholder' => 'Ingresa capacidad']) !!}
      </div>

      <div class="form-group">
         {!! Form::label('campus', 'Campus') !!}
       {!! Form::select('campus_id', ( $campus), null, ['class' => 'form-control'])!!}
      </div>


      <div class="form-group">
         {!! Form::label('tipo', 'Tipo') !!}
       {!! Form::select('tipo_sala_id', ( $tipos_salas), null, ['class' => 'form-control'])!!}
      </div>

      <div class="form-group">
       {!! Form::label('descripcion', 'Descripción') !!}
       {!! Form::text('descripcion', null,['class' => 'form-control', 'placeholder' => 'Ingresa descripción']) !!}
      </div>


       {!! Form::hidden('id', $id)!!}

      <div align=center><button type="submit" class="btn btn-info">Actualizar</button></div>

      {!! Form::close() !!}


</div>
</div>
</div>

                    
</div>


      </div>
    </div>


                    
@stop