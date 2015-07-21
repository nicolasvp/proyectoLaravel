@extends('layouts/master')

@section('sideBar')





            @include('Administrador/menu') 
 

<div class="col-sm-9" >
  <p> <h2>Editar los datos de la carrera {{ $carreraEditable->nombre }}</h2></p>
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">
       <div class="form-group">
  
      {!! Form::model($carreraEditable, ['action' => ['AdministradorController@put_updateCarrera', $carreraEditable], 'method' => 'PUT']) !!}

       <div class="form-group">
       {!! Form::label('escuela_id', 'Escuela') !!}
       {!! Form::select('escuela_id', (['0' => '-- Seleccionar una escuela --'] +$escuelas), null, ['class' => 'form-control'])!!}
      </div>


      <div class="form-group">
       {!! Form::label('codigo', 'Código') !!}
       {!! Form::text('codigo', null,['class' => 'form-control', 'placeholder' => 'Ingresa código']) !!}   
      </div>

      <div class="form-group">
        {!! Form::label('nombre', 'Nombre') !!}
       {!! Form::text('nombre', null,['class' => 'form-control', 'placeholder' => 'Ingresa nombre']) !!}
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
    </div>

@stop