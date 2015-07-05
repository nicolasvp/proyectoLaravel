@extends('layouts/master')


@section('sideBar')

              
             @include('Administrador/menu')
       


<div class="col-sm-9" >
  <p> <h2>Editar los datos del departamento {{ $departamentoEditable->nombre }}</h2></p>
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">
       <div class="form-group">
  
      {!! Form::model($departamentoEditable, ['action' => ['AdministradorController@put_updateDepartamento', $departamentoEditable], 'method' => 'PUT']) !!}

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