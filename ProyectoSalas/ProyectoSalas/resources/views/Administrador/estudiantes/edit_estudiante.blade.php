@extends('layouts/master')


@section('sideBar')



         
           @include('Administrador/menu')
       

<div class="col-sm-9" >
  <p> <h2>Editar los datos del estudiante: {{ $estudianteEditable->nombres }} {{$estudianteEditable->apellidos}}</h2></p>
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">
       <div class="form-group">
  
      {!! Form::model($estudianteEditable, ['action' => ['AdministradorController@put_updateEstudiante', $estudianteEditable], 'method' => 'PUT']) !!}

      <div class="form-group">
       {!! Form::label('carrera_id', 'Carrera') !!}
       {!! Form::select('carrera_id', (['0' => '-- Seleccionar una carrera --'] +$carreras), null, ['class' => 'form-control'])!!}
      </div>


      <div class="form-group">
       {!! Form::label('rut', 'Rut') !!}
       {!! Form::text('rut', null,['class' => 'form-control', 'placeholder' => 'Ingresa rut']) !!}
         
      </div>

      <div class="form-group">
        {!! Form::label('nombres', 'Nombres') !!}
       {!! Form::text('nombres', null,['class' => 'form-control', 'placeholder' => 'Ingresa nombres']) !!}
      </div>

        <div class="form-group">
        {!! Form::label('apellidos', 'Apellidos') !!}
       {!! Form::text('apellidos', null,['class' => 'form-control', 'placeholder' => 'Ingresa apellidos']) !!}
      </div>

        <div class="form-group">
        {!! Form::label('email', 'Email') !!}
       {!! Form::text('email', null,['class' => 'form-control', 'placeholder' => 'Ingresa email']) !!}
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