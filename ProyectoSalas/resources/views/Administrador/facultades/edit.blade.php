@extends('layouts/master')

@section('sideBar')


      
<div class="panel panel-default" style="margin-top: 40px;">
           @include('Administrador/menu')  
       
  <div class="panel-body">                  
                  
   <div class="row">
<div class="col-sm-9" >
  <p> <h2>Editar los datos de la facultad: {{ $facultadEditable->nombre }}</h2></p>
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">

        @include('Administrador/messages')

       <div class="form-group">
  
      {!! Form::model($facultadEditable, ['action' => ['Administrador\FacultadController@put_update', $facultadEditable], 'method' => 'PUT']) !!}

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
       {!! Form::textarea('descripcion', null,['class' => 'form-control', 'placeholder' => 'Ingresa descripción']) !!}
      </div>

        {!! Form::hidden('id', $id)!!}

      <div align=center><button type="submit" class="btn btn-success">Actualizar</button></div>

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