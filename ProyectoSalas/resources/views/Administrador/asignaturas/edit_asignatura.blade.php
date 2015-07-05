@extends('layouts/master')




@section('sideBar')


        
         @include('Administrador/menu')  



<div class="col-sm-9" >
  <p> <h2>Editar los datos de la asignatura: {{ $asignaturaEditable->nombre }}</h2></p>
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">
       <div class="form-group">
  
      {!! Form::model($asignaturaEditable, ['action' => ['AdministradorController@put_updateAsignatura', $asignaturaEditable], 'method' => 'PUT']) !!}

      <div class="form-group">
       {!! Form::label('departamento_id', 'Departamento') !!}
       {!! Form::select('departamento_id', (['0' => '-- Seleccionar un departamento --'] +$departamentos), null, ['class' => 'form-control'])!!}
      </div>


      <div class="form-group">
       {!! Form::label('nombre', 'Nombre') !!}
       {!! Form::text('nombre', null,['class' => 'form-control', 'placeholder' => 'Ingresa nombre']) !!}
         
      </div>

      <div class="form-group">
        {!! Form::label('codigo', 'Código') !!}
       {!! Form::text('codigo', null,['class' => 'form-control', 'placeholder' => 'Ingresa código']) !!}
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