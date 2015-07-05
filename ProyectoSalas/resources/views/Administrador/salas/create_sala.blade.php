@extends('layouts/master')

@section('sideBar')


   
           @include('Administrador/menu')


         <div class="col-sm-9" >
   <p> <h2>Ingrese los datos para la sala</h2></p>
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">
       <div class="form-group">
  
      {!! Form::open(['action' => ['AdministradorController@post_storeSala'], 'method' => 'POST']) !!}


        <div class="form-group">
         {!! Form::label('campus', 'Campus') !!}
       {!! Form::select('campus_id', ( $campus), null, ['class' => 'form-control'])!!}
      </div>


      <div class="form-group">
         {!! Form::label('tipo', 'Tipo') !!}
       {!! Form::select('tipo_sala_id', ( $tipos_salas), null, ['class' => 'form-control'])!!}
      </div>

       <div class="form-group">
       {!! Form::label('nombre', 'Nombre') !!}
       {!! Form::text('nombre', null,['class' => 'form-control', 'placeholder' => 'Ingresa nombre']) !!}
      </div>

        <div class="form-group">
       {!! Form::label('descripcion', 'Descripción') !!}
       {!! Form::text('descripcion', null,['class' => 'form-control', 'placeholder' => 'Ingresa descripción']) !!}
      </div>


      <div class="form-group">
        {!! Form::label('capacidad', 'Capacidad') !!}
       {!! Form::text('capacidad', null,['class' => 'form-control', 'placeholder' => 'Ingresa capacidad']) !!}
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