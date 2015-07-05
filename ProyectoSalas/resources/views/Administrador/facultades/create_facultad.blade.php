@extends('layouts/master')


@section('sideBar')


        
            @include('Administrador/menu')
       


         <div class="col-sm-9" >
   <p> <h2>Ingrese los datos para la facultad</h2></p>
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">
       <div class="form-group">
  
      {!! Form::open(['action' => ['AdministradorController@post_storeFacultad'], 'method' => 'POST']) !!}


      <div class="form-group">
       {!! Form::label('campus_id', 'Campus') !!}
       {!! Form::select('campus_id', (['0' => '-- Seleccionar un campus --'] +$campus), null, ['class' => 'form-control'])!!}
      </div>

      <div class="form-group">
        {!! Form::label('nombre', 'Nombre') !!}
       {!! Form::text('nombre', null,['class' => 'form-control', 'placeholder' => 'Ingresa nombre']) !!}
      </div>

        <div class="form-group">
        {!! Form::label('descripcion', 'Descripción') !!}
       {!! Form::text('descripcion', null,['class' => 'form-control', 'placeholder' => 'Ingresa descripción']) !!}
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