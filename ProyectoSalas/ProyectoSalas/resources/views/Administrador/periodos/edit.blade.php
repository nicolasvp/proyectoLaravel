@extends('layouts/master')


@section('sideBar')


           
             @include('Administrador/menu')


<div class="col-sm-9" >
  <p> <h2>Editar los datos del periodo {{ $periodoEditable->bloque }}</h2></p>
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">
       <div class="form-group">
  
      {!! Form::model($periodoEditable, ['action' => ['Administrador\PeriodoController@put_update', $periodoEditable], 'method' => 'PUT']) !!}

      <div class="form-group">
       {!! Form::label('bloque', 'Bloque') !!}
       {!! Form::text('bloque', null,['class' => 'form-control', 'placeholder' => 'Ingresa bloque']) !!}
         
      </div>

      <div class="form-group">
        {!! Form::label('inicio', 'Inicio') !!}
       {!! Form::text('inicio', null,['class' => 'form-control', 'placeholder' => 'Ingresa hora inicio']) !!}
      </div>

        <div class="form-group">
        {!! Form::label('fin', 'Fin') !!}
       {!! Form::text('fin', null,['class' => 'form-control', 'placeholder' => 'Ingresa hora fin']) !!}
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