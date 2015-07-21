@extends('layouts/master')




@section('sideBar')



     @include('Administrador/menu')
       


<div class="col-sm-9" >
  <p> <h2>Editar los datos del docente: {{ $docenteEditable->nombres }} {{$docenteEditable->apellidos}}</h2></p>
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">

       @include('Administrador/messages')
       
       <div class="form-group">
  
      {!! Form::model($docenteEditable, ['action' => ['Administrador\DocenteController@put_update', $docenteEditable], 'method' => 'PUT']) !!}

      <div class="form-group">
       {!! Form::label('departamento', 'Departamento') !!}
       {!! Form::select('departamento_id', (['0' => '-- Seleccionar un Departamento --'] +$departamentos), null, ['class' => 'form-control'])!!}
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

@stop